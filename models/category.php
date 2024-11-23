<?php

    /**
     * Модель для работы с таблицей 'categories'
     */
    class Category
    {
        /**
         * @var false|mysqli|null Подключение к БД
         */
        private $connect;

        /**
         * Конструктор
         */
        public function __construct()
        {
            $this->connect = DB::getConnect();
        }

        /**
         * Метод для получения массива со всеми категориями, которые не удалены
         * @return array|false|null Двумерный массив, который хранит ассоциативные массивы с информацией по каждой категории (name, id и тд)
         */
        public function getAll()
        {
            $query = "
                SELECT * 
                FROM `categories`
                WHERE `category_is_deleted` = 0;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        /**
         * @param int $limit Сколько записией выводить при пагинации
         * @param int $offset С какой записи выводить пагинацию
         * @return array Массив с информацией по каждой категории
         */
        public function getAllPaginated(int $limit, int $offset)
        {
            $query = "
                SELECT * 
                FROM `categories`
                WHERE `category_is_deleted` = 0
                LIMIT $offset, $limit;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        /**
         * Добавление категории
         * @param string $nameCategory Название категории
         * @return bool|mysqli_result Булево значение успешно выполнен запрос или нет
         */
        public function insert($nameCategory)
        {
            $query = "
                INSERT INTO `categories`
                SET `category_name` = '$nameCategory'
            ";
            return mysqli_query($this->connect, $query);
        }

        /**
         * Получение названия категории с переданным id
         * @param int $id ID категории
         * @return array|false|null Ассоциативный массив, который содержит название категории товаров
         */
        public function getById($id)
        {
            $query = "
                SELECT `category_name`
                FROM `categories`
                WHERE `category_id` = $id AND `category_is_deleted` = 0;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }

        /**
         * Обновление названия категории товаров
         * @param string $nameCategory Измененное название категории
         * @param int $id ID катеогрии, которую меняем
         * @return bool Булево значение успешно выполнен запрос или нет
         */
        public function edit($nameCategory, $id)
        {
            $query = "
                UPDATE `categories`
                SET `category_name` = '$nameCategory'
                WHERE `category_id` = $id;
            ";
            return mysqli_query($this->connect, $query);
        }

        /**
         * Обновление значения 'category_is_deleted' для категории товаров с переданным id, тем самым 'удаляет' ее
         * @param int $id ID категории, которую нужно 'удалить'
         * @return bool Булево значение успешно выполнен запрос или нет
         */
        public function remove($id)
        {
            $query = "
                UPDATE `categories`
                SET `category_is_deleted` = 1
                WHERE `category_id` = $id;
            ";
            return mysqli_query($this->connect, $query);
        }

        /**
         * Метод для подсчета количества всех неудаленных категорий товаров
         * @return int Количество категорий
         */
        public function getTotal()
        {
            $query = "
                SELECT COUNT(*) AS `count`
                FROM `categories`
                WHERE `category_is_deleted` = 0;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result)['count'];
        }

    }
