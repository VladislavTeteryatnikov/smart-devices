<?php

    /**
     * Модель для работы с таблицей 'users'
     */
    class User
    {
        /**
         * @var false|mysqli|null Подключение к БД
         */
        private $connect;

        /**
         * @var object Helper Объект-помощник
         */
        private $helper;

        /**
         * Конструктор
         */
        public function __construct()
        {
            $this->connect = DB::getConnect();
            $this->helper = new Helper();
        }

        /**
         * Проверка, что пользователь существует
         * @param string $email Email
         * @return mixed Число пользователей с таким email
         */
        public function checkIfUserExists(string $email)
        {
            $query = "
                SELECT COUNT(*) AS `count`
                FROM `users`
                WHERE `user_email` = '$email';
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result)['count'];
        }

        /**
         * Регистрация пользователя. Добавление пользователя в БД
         * @param string $name Имя пользователя
         * @param string $email Email пользователя
         * @param string $hashedPassword Хэш пароль
         * @return bool|mysqli_result Булево значение успешно выполнен запрос или нет
         */
        public function register(string $name, string $email, string $hashedPassword)
        {
            $query = "
                INSERT INTO `users`
                SET `user_name` = '$name',
                    `user_email` = '$email',
                    `user_password` = '$hashedPassword';
            ";
            return mysqli_query($this->connect, $query);
        }

        /**
         * Проверка, что в БД есть пользователь с такой связкой email/пароль
         * @param string $email
         * @param string $hashedPassword
         * @return array|false|null Массив с количеством пользователей и с id пользователя с такой связкой email/пароль
         */
        public function getUserInfo(string $email, string $hashedPassword)
        {
            $query = "
                SELECT COUNT(*) AS `count`, `user_id`
                FROM `users`
                WHERE `user_email` = '$email' AND `user_password` = '$hashedPassword';
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }

        /**
         * Добавлении в БД запись о подключении, когда пользователь авторизовался
         * @param int $userId ID пользователя
         * @param string $token Псевдо случайно сгенерированная строка
         * @param int $tokenTime Метка времени
         * @return bool|mysqli_result Булево значение успешно выполнен запрос или нет
         */
        public function auth(int $userId, string $token, int $tokenTime)
        {
            //Добавляем в БД запись о подключении пользователя
            $query = "
                INSERT INTO `connects`
                SET `connect_user_id` = $userId,
                    `connect_token` = '$token',
                    `connect_token_time` = FROM_UNIXTIME($tokenTime);
            ";
            return mysqli_query($this->connect, $query);
        }

        /**
         * Проверка, что пользователь авторизоан
         * @return bool Булево значение авторизован пользователь или нет
         */
        public function checkIfUserAuthorized()
        {
            if (!isset($_COOKIE['uid']) || !isset($_COOKIE['t']) || !isset($_COOKIE['tt'])) {
                return false;
            }

            $userId = htmlentities($_COOKIE['uid']);
            $token = htmlentities($_COOKIE['t']);
            $tokenTime = htmlentities($_COOKIE['tt']);

            $query = "
                SELECT `connect_id`
                FROM `connects`
                WHERE `connect_user_id` = $userId
                    AND `connect_token` = '$token';
            ";
            $result = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($result) == 0) {
                return false;
            } else {
                $connectId = mysqli_fetch_assoc($result)['connect_id'];
            }
            if ($tokenTime < time()) {
                $newToken = $this->helper->generateToken();
                $newTokenTime = time() + 3 * 60;
                setcookie("uid", $userId, time() + 2 * 24 * 3600, '/');
                setcookie("t", $newToken, time() + 2 * 24 * 3600, '/');
                setcookie("tt", $newTokenTime, time() + 2 * 24 * 3600, '/');
                $query = "
                    UPDATE `connects`
                        SET `connect_token` = '$newToken',
                            `connect_token_time` = FROM_UNIXTIME($newTokenTime)
                    WHERE `connect_id` = $connectId;
                ";
                mysqli_query($this->connect, $query);
            }
            return true;
        }

        /**
         * Проверка, что у пользователя есть права админа
         * @return bool|void true если права админа есть
         */
        public function checkIfUserAdmin()
        {
            if (isset($_COOKIE['uid'])){
                $userId = htmlentities($_COOKIE['uid']);
                $query = "
                    SELECT `user_is_admin`
                    FROM `users`
                    WHERE `user_id` = $userId;
                ";
                $result = mysqli_query($this->connect, $query);
                $isAdmin = mysqli_fetch_assoc($result)['user_is_admin'];
                if ($isAdmin){
                    return true;
                }
            }
        }

        /**
         * Выход пользователя из личного кабинета
         * @return bool|mysqli_result|void Булево значение успешно выполнен запрос или нет
         */
        public function logout()
        {
            if (isset($_COOKIE['uid']) && isset($_COOKIE['t'])) {
                $userId = htmlentities($_COOKIE['uid']);
                $token = htmlentities($_COOKIE['t']);
                $query = "
                    DELETE FROM `connects`
                        WHERE `connect_user_id` = $userId
                            AND `connect_token` = '$token';
                ";
                return mysqli_query($this->connect, $query);
            }
        }

        /**
         * @return mixed Количество пользователей
         */
        public function getTotal()
        {
            $query = "
                SELECT COUNT(*) AS `count`
                FROM `users`
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result)['count'];
        }

        /**
         * @param int $limit Сколько записией выводить при пагинации
         * @param int $offset С какой записи выводить пагинацию
         * @return array Массив с информацией по каждому пользователю
         */
        public function getAllPaginated(int $limit, int $offset)
        {
            $query = "
                SELECT `user_id`, `user_name`, `user_email`, `user_is_admin`
                FROM `users`
                ORDER BY `user_id` DESC
                LIMIT $offset, $limit; 
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        /**
         * Получение данных пользователя по ID
         * @param int $id ID пользователя
         * @return array|false|null Массив с данными пользователя
         */
        public function getById(int $id)
        {
            $query = "
                SELECT `user_id`, `user_name`, `user_email`, `user_is_admin`
                FROM `users`
                WHERE `user_id` = '$id'; 
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }

        /**
         * Редактирование данных пользователя
         * @param array $data Массив с данными для редактирования пользователя
         * @return bool|mysqli_result Булево значение успешно выполнен запрос или нет
         */
        public function edit(array $data)
        {
            $query = "
                UPDATE `users`
                    SET `user_name` = '$data[userName]',
                        `user_email` = '$data[userEmail]',
                        `user_is_admin` = $data[userIsAdmin]
                WHERE `user_id` = $data[userId];
            ";
            return mysqli_query($this->connect, $query);
        }

        /**
         * Удаление пользователя
         * @param int $id ID пользователя
         * @return bool|mysqli_result Булево значение успешно выполнен запрос или нет
         */
        public function remove(int $id)
        {
            $query = "
                DELETE FROM `users`
                WHERE `user_id` = $id;
            ";
            return mysqli_query($this->connect, $query);
        }

    }