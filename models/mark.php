<?php

    /**
     * Модель для работы с таблицей 'marks' (оценки товаров от пользователей)
     */
    class Mark
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
         * Информация об оценках по конкретному товару
         * @param int $productId ID товара
         * @return array Массив с информацией об оценках для товара
         */
        public function getByProductId($productId)
        {
            $query = "
                SELECT `mark_value`, `user_name`, `mark_dignities`, `mark_disadvantages`, `mark_comment`, `mark_created` 
                FROM `marks`
                LEFT JOIN `users` ON `mark_user_id` = `user_id`
                WHERE `mark_product_id` = $productId
                ORDER BY `mark_id` DESC;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        /**
         * Количество оценок для товара
         * @param int $productId ID товара
         * @return array|false|null Массив с информацией о количестве оценок для данного товара
         */
        public function getCountByProductId($productId)
        {
            $query = "
                SELECT COUNT(*) as `count`
                FROM `marks`
                WHERE `mark_product_id` = $productId;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }

        /**
         * Средняя оценка для товара
         * @param int $productId ID товара
         * @return array|false|null Массив с информацией о средней оценоке для данного товара
         */
        public function getAvgByProductId($productId)
        {
            $query = "
                SELECT AVG(`mark_value`) as `avg`
                FROM `marks`
                WHERE `mark_product_id` = $productId;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }

        /**
         * Информация о количестве каждой оценки для товара
         * @param int $productId ID товара
         * @return array Массив с данными о том, какую оценку сколько раз поставили для данного товара
         */
        public function groupByValue($productId)
        {
            $query = "
                SELECT `mark_value`, COUNT(`mark_value`) as `count`
                FROM `marks`
                WHERE `mark_product_id` = $productId
                GROUP BY `mark_value` DESC;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        /**
         * Добавление оценки товара
         * @param array $data Массив с данными (оценка; id пользователя, который поставил и тд)
         * @return bool|mysqli_result Булево значение успешно выполнен запрос или нет
         */
        public function insertMark(array $data)
        {
            $query = "
                INSERT INTO `marks`
                    SET `mark_value` = $data[mark],
                        `mark_user_id` = $data[userId],
                        `mark_product_id` = $data[productId],
                        `mark_dignities` = '$data[dignities]',
                        `mark_disadvantages` = '$data[disadvantages]',
                        `mark_comment` = '$data[comment]'
            ";
            return mysqli_query($this->connect, $query);
        }

    }
