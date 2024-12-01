<?php

    /**
     * Модель для работы с таблицей 'products'
     */
    class Product
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
         * Получение всех товаров и связанной с ними информации
         * @return array Массив с информацией по каждому товару
         */
        public function getAll()
        {
            $query = "
                SELECT `product_id`, `product_name`, `product_code`, `category_name`, `product_price`, `product_sale`, `manufacturer_name`, `product_description`, `product_img`
                FROM `products`
                LEFT JOIN `categories` ON `product_category_id` = `category_id`
                LEFT JOIN `manufacturers` ON `product_manufacturer_id` = `manufacturer_id`
                WHERE `product_is_deleted` = 0
                ORDER BY `product_id` DESC; 
            ";
           $result = mysqli_query($this->connect, $query);
           return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        /**
         * Массив с товарами для пагинации
         * @param int $limit Сколько записией выводить при пагинации
         * @param int $offset С какой записи выводить пагинацию
         * @return array Массив с информацией по каждому товару
         */
        public function getAllPaginated($limit, $offset)
        {
            $query = "
                SELECT `product_id`, `product_name`, `product_code`, `product_price`, `product_sale`, `category_name`, `manufacturer_name`, `product_description`, `product_img`
                FROM `products`
                LEFT JOIN `categories` ON `product_category_id` = `category_id`
                LEFT JOIN `manufacturers` ON `product_manufacturer_id` = `manufacturer_id`
                WHERE `product_is_deleted` = 0
                ORDER BY `product_id` DESC
                LIMIT $offset, $limit; 
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        /**
         * Массив с товарами для пагинации определенной категории
         * @param int $limit Сколько записией выводить при пагинации
         * @param int $offset С какой записи выводить пагинацию
         * @param int $categoryId ID категории
         * @return array Массив с информацией по каждому товару определенной категории
         */
        public function getAllPaginatedByCategoryId($limit, $offset, $categoryId)
        {
            $query = "
                SELECT `product_id`, `product_name`, `category_name`, `product_price`, `product_sale`, `manufacturer_name`, `product_description`, `product_img`
                FROM `products`
                LEFT JOIN `categories` ON `product_category_id` = `category_id`
                LEFT JOIN `manufacturers` ON `product_manufacturer_id` = `manufacturer_id`
                WHERE `product_is_deleted` = 0 AND `product_category_id` = $categoryId
                ORDER BY `product_id` DESC
                LIMIT $offset, $limit; 
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        /**
         * Массив с товарами для пагинации определенной категории с учетом фильтров поиска
         * @param int $limit Сколько записией выводить при пагинации
         * @param int $offset С какой записи выводить пагинацию
         * @param int $categoryId ID категории
         * @param array $manufacturersFilter Фильтр по производителю
         * @param array $pricesFilter Фильтр по цене
         * @return array Массив с информацией по каждому товару определенной категории с учетом фмльтров
         */
        public function getAllPaginatedByCategoryIdByFilter($limit, $offset, $categoryId, array $manufacturersFilter, array $pricesFilter)
        {
            $query = "
                SELECT `product_id`, `product_name`, `category_name`, `product_price`, `product_sale`, `manufacturer_name`, `product_description`, `product_img`
                FROM `products`
                LEFT JOIN `categories` ON `product_category_id` = `category_id`
                LEFT JOIN `manufacturers` ON `product_manufacturer_id` = `manufacturer_id`
                WHERE `product_is_deleted` = 0 AND `product_category_id` = $categoryId AND `product_price` >= $pricesFilter[priceFrom] AND `product_price` <= $pricesFilter[priceTo] AND (";
            if (!empty($manufacturersFilter)) {
                foreach ($manufacturersFilter as $manufacturerFilter) {
                    $query .= "`manufacturer_name` = '$manufacturerFilter' OR ";
                }
                $query = substr($query, 0, -3);
                $query .= ") ORDER BY `product_id` DESC
                LIMIT $offset, $limit;";
            } else {
                $query = substr($query, 0, -6);
                $query .= " ORDER BY `product_id` DESC
                LIMIT $offset, $limit;";
            }

            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        /**
         * Получение массива с товарами, на которые есть скидка
         * @return array Массив с товарами, на которые есть скидка
         */
        public function getProductsWithSale()
        {
            $query = "
                SELECT `product_id`, `product_name`, `product_price`, `product_sale`, `product_img`
                FROM `products`
                WHERE `product_is_deleted` = 0 AND `product_sale` > 0
                ORDER BY `product_id` DESC; 
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        /**
         * Добавление нового товара
         * @param array $data Массив с информацией о товаре, который добавляем
         * @return bool|mysqli_result Булево значение успешно выполнен запрос или нет
         */
        public function insert(array $data)
        {
            $query = "
                INSERT INTO `products`
                    SET `product_name` = '$data[name]',
                        `product_price` = $data[price],
                        `product_code` = $data[code],
                        `product_sale` = $data[sale],
                        `product_manufacturer_id` = $data[manufacturer],
                        `product_category_id` = $data[category],
                        `product_description` = '$data[description]',
                        `product_img` = '$data[name_img]';
            ";
            return mysqli_query($this->connect, $query);
        }

        /**
         * Получение информации о товаре по id
         * @param int $id ID товара
         * @return array|false|null Массив с информацией по товару с определенным ID
         */
        public function getById(int $id)
        {
            $query = "
                SELECT `product_name`, `product_code`, `product_category_id`, `product_price`, `product_sale`, `product_manufacturer_id`, `product_description`, `product_img`
                FROM `products`
                WHERE `product_id` = '$id'; 
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }

        /**
         * Редактирование товара с определенным ID
         * @param array $data Массив с информацией о товаре, который редактируем
         * @param int $id ID товара
         * @return bool|mysqli_result Булево значение успешно выполнен запрос или нет
         */
        public function edit(array $data, int $id)
        {
            $query = "
                UPDATE `products`
                SET `product_name` = '$data[name]',
                    `product_price` = $data[price],
                    `product_code` = $data[code],
                    `product_sale` = $data[sale],
                    `product_manufacturer_id` = $data[manufacturer],
                    `product_category_id` = $data[category],
                    `product_description` = '$data[description]',
                    `product_img` = '$data[name_img]'
                WHERE `product_id` = $id;
            ";
            return mysqli_query($this->connect, $query);
        }

        /**
         * Удаление товара с помощью изменения колоник 'product_is_deleted'
         * @param int $id ID товара
         * @return bool|mysqli_result Булево значение успешно выполнен запрос или нет
         */
        public function remove(int $id)
        {
            $query = "
                UPDATE `products`
                SET `product_is_deleted` = 1
                WHERE `product_id` = $id;
            ";
            return mysqli_query($this->connect, $query);
        }

        /**
         * Получение числа неудаленных товаров
         */
        public function getTotal()
        {
            $query = "
                SELECT COUNT(*) AS `count`
                FROM `products`
                WHERE `product_is_deleted` = 0;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result)['count'];
        }

        /**
         * Получение числа товаров в определенной категории
         * @param int $categoryId ID категории
         */
        public function getCountByCategoryId(int $categoryId)
        {
            $query = "
                SELECT COUNT(*) AS `count`
                FROM `products`
                WHERE `product_is_deleted` = 0 AND `product_category_id` = $categoryId;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result)['count'];
        }

        /**
         * @param array $data Массив с ID товаров, которые в корзине
         * @return array Массив с данными о товарах, находящихся в корзине
         */
        public function getProductForCart(array $data)
        {
            $query = "
                SELECT `product_id`, `product_name`, `product_price`, `product_sale`, `product_img`
                FROM `products`
                WHERE
            ";
            foreach ($data as $productId => $count){
                $query .= " `product_id` = $productId OR";
            }
            $query = substr($query, 0, -3);
            $query .= ";";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }


    }