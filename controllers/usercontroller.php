<?php

    /**
     * Контроллер для работы с пользователями. Регистрация, авторизация, выход из учетной записи, а также просмотр, изменение и удаление данных о пользователях (доступно только администраторам)
     */
    class UserController extends BaseController
    {
        /**
         * @var object Helper. Объект-помощник
         */
        private $helper;

        /**
         * @var object Validation. Объект для валидации данных
         */
        private $validation;

        /**
         * Констуктор
         */
        public function __construct()
        {
            parent::__construct();
            $this->helper = new Helper();
            $this->validation = new Validation();
        }

        /**
         * Регистрация новых пользователей. Выводит view с формой регистрации
         */
        public function actionReg()
        {
            $errors = [];
            //Обрабатываем отправленную форму регистрации пользователя
            if (isset($_POST['name'])) {
                $name = htmlentities($_POST['name']);
                $email = htmlentities($_POST['email']);
                $password = htmlentities($_POST['password']);
                $repeatPassword = htmlentities($_POST['repeat_password']);

                //Производим валидацию данных
                if (empty($name) || empty($email) || empty($password) || empty($repeatPassword)){
                    $errors[] = "Необходимо заполнить все поля";
                }
                if ($this->validation->userNameCheck($name) && $this->validation->checkLength($name)){
                    $errors[] = "Введите имя пользователя без пробелов на кириллице";
                }
                if ($this->validation->emailCheck($email) && $this->validation->checkLength($email)){
                    $errors[] = "Введен некорректный email";
                }
                if ($this->validation->passwordCheck($password)){
                    $errors[] = "Пароль должен содержать от 6 до 10 символов. Обязательно цифра, заглавная и строчная буквы";
                }
                if (!isset($_POST['agree'])){
                    $errors[] = "Не принято соглашение на обработку персональных данных";
                }
                //Проверяем, что пользователь ввел оба раза одинаковый пароль
                if ($password !== $repeatPassword) {
                    $errors[] = "Пароли не совпадают";
                } else {
                    $count = $this->userModel->checkIfUserExists($email);
                    //Если нашлось совпадение, то выводим ошибку
                    if ((int)$count === 1) {
                        $errors[] = "Такой email уже зарегистрирован";
                    }
                    if ($this->validation->validateRecaptcha()){
                        $errors[] = 'Ошибка заполнения капчи';
                    }
                    if (empty($errors)) {
                        //Хэшируем пароль и вносим данные пользователя в БД
                        $hashedPassword = md5($password);
                        //TODO: строка $name принимает вид первая заглавная, остальные строчные
                        $this->userModel->register($name, $email, $hashedPassword);

                        //Генерируем токен, производим авторизацию только что зарегистрированного пользователя и устанавливаем куки
                        $token = $this->helper->generateToken();
                        $tokenTime = time() + 30 * 60;
                        $userInfo = $this->userModel->getUserInfo($email, $hashedPassword);
                        $userId = $userInfo['user_id'];
                        $this->userModel->auth($userId, $token, $tokenTime);

                        setcookie("uid", $userId, time() + 2 * 24 * 3600, '/');
                        setcookie("t", $token, time() + 2 * 24 * 3600, '/');
                        setcookie("tt", $tokenTime, time() + 2 * 24 * 3600, '/');

                        header('Location:' . FULL_SITE_ROOT . 'cart');
                    }
                }
            }

            $title = 'Регистрация';
            include_once("views/users/reg.html");
        }

        /**
         * Авторизация пользователей. Выводит view с формой авторизации
         */
        public function actionAuth()
        {
            $errors = [];
            //Обрабатываем отправленную форму авторизации пользователя
            if (isset($_POST['email'])) {
                $email = htmlentities($_POST['email']);
                $password = htmlentities($_POST['password']);
                //Хэшируем пароль для запроса к БД
                $hashedPassword = md5($password);
                $userInfo = $this->userModel->getUserInfo($email, $hashedPassword);
                if ($userInfo['count'] === '0') {
                    $errors[] = "Такой связки email / пароль не существует";
                }
                if ($this->validation->validateRecaptcha()){
                    $errors[] = 'Ошибка заполнения капчи';
                }

                if (empty($errors)) {
                    //Генерируем токен, делаем авторизацию пользователя и устанавливаем куки
                    $token = $this->helper->generateToken();
                    $tokenTime = time() + 3 * 60;
                    //Забираем id пользователя, если он прошел авторизацию
                    $userId = $userInfo['user_id'];
                    $this->userModel->auth($userId, $token, $tokenTime);

                    setcookie("uid", $userId, time() + 2 * 24 * 3600, '/');
                    setcookie("t", $token, time() + 2 * 24 * 3600, '/');
                    setcookie("tt", $tokenTime, time() + 2 * 24 * 3600, '/');

                    header('Location:' . FULL_SITE_ROOT . 'cart');;
                }
            }

            $title = 'Авторизация';
            include_once("views/users/auth.html");
        }

        /**
         * Выход пользователя из учетной записи
         */
        public function actionLogout()
        {
            $this->userModel->logout();
            setcookie("uid", "", time() - 10, '/');
            setcookie("t", "", time() - 10, '/');
            setcookie("tt", 0, time() - 10, '/');
            header('Location:' . FULL_SITE_ROOT );;
        }

        /**
         * Выводит view с таблицей, в которой находится список пользователей (только для администратора)
         * @param int $page Номер страницы для пагинации
         */
        public function actionIndex($page = 1)
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }

            //Данные для пагинации
            $total = $this->userModel->getTotal();
            $limit = 10;
            $currentPage = $page;
            $index = 'page=';
            $offset = ($page - 1) * $limit;
            $pagination = new Pagination($total, $currentPage, $limit, $index);
            $users = $this->userModel->getAllPaginated($limit, $offset);

            $title = 'Пользователи';
            include_once ("views/users/table.html");
        }

        /**
         * Редактирование данных пользователя (только для администратора)
         * @param int $id ID пользователя, данные которого необходимо редактировать
         */
        public function actionEdit($id)
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            $errors = [];
            //Получаем данные пользователя
            $user = $this->userModel->getById($id);
            //Обрабатываем форму
            if (isset($_POST['user_name'])){
                $userName = htmlentities($_POST['user_name']);
                $userEmail = htmlentities($_POST['user_email']);
                $userIsAdmin = htmlentities($_POST['user_is_admin']);
                $data = array(
                    'userId' => $id,
                    'userName' => $userName,
                    'userEmail' => $userEmail,
                    'userIsAdmin' => $userIsAdmin
                );

                //TODO: проверка на регулярки
                //Если валидация пройдена успешно
                if (empty($errors)){
                    //Если данные были оставлены без изменений
                    if ($user['user_name'] === $userName  && $user['user_email'] === $userEmail && $user['user_is_admin'] === $userIsAdmin){
                        header('Location:' . FULL_SITE_ROOT . 'admin/users');
                        die();
                    }
                    //Если были внесены какие-то изменения в данные пользователя
                    if ($user['user_name'] !== $userName || $user['user_email'] !== $userEmail || $user['user_is_admin'] !== $userIsAdmin) {
                        //TODO: проверка, что такой почты уже нет у другого пользователя
                        $result = $this->userModel->edit($data);
                        if ($result) {
                            header('Location:' . FULL_SITE_ROOT . 'admin/users');
                        } else {
                            $errors[] = "Не удалось добавить данные в таблицу";
                        }
                    }
                }

            }
            $title = 'Редактирование данных пользователя';
            include_once ("views/users/form.html");
        }

        /**
         * Удаление пользователя (только для администратора)
         * @param int $id ID пользователя, которого нужно удалить
         */
        public function actionDelete($id)
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            $errors = [];
            //TODO: проверка, что id передан верно, и он существует. Затем удаление пользовтеля, если валидация пройдена успешно
            $this->userModel->remove($id);
            header('Location:' . FULL_SITE_ROOT . 'admin/users');
        }

    }

