<?php
    /**
     * Модель для работы с таблицей 'carts'
     */
    class Cart
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
         * Добавление информации по заказу пользователя в таблицу 'carts'
         * @param array $dataItems Массив с информацией о товарах в корзине вида ID товара => количество товара
         * @param int $orderId ID заказа
         * @return bool|mysqli_result
         */
        public function insert($dataItems, $orderId)
        {
            $query = "
                INSERT `carts` (`cart_product_id`, `cart_product_count`, `cart_order_id`)
                VALUES
            ";
            foreach ($dataItems as $productId => $productCount){
                $query .= "($productId, $productCount, $orderId),";
            }
            $query = substr($query, 0, -1);
            $query .= ";";
            return mysqli_query($this->connect, $query);
        }

        /**
         * Массив с заказами определенного пользователя
         * @param int $userId ID пользователя
         * @return array Массив оформленных заказов пользователем
         */
        public function getCartsByUserId($userId)
        {
            $query = "
                SELECT `product_name`, `cart_product_count`, `order_id`, `order_delivery_time`, `delivery_name`, `status_name`, `product_price`, `product_sale`
                FROM `carts`
                LEFT JOIN `orders` ON `cart_order_id` = `order_id`
                LEFT JOIN `deliveries` ON `order_delivery_id` = `delivery_id`
                LEFT JOIN `products` ON `cart_product_id` = `product_id`
                LEFT JOIN `statuses` ON `order_status_id` = `status_id`
                WHERE `order_user_id` = $userId
                ORDER BY `order_id` DESC;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        /**
         * Отсортировання массив с заказами пользователя
         * @param int $userId ID пользователя
         * @param string $sortSql Порядок сортировки
         * @return array Отсортированный массив с данными по заказам пользователя
         */
        public function getCartsByUserIdSort($userId, $sortSql)
        {
            $query = "
                SELECT `product_name`, `cart_product_count`, `order_id`, `order_delivery_time`, `delivery_name`, `status_name`, `product_price`, `product_sale`
                FROM `carts`
                LEFT JOIN `orders` ON `cart_order_id` = `order_id`
                LEFT JOIN `deliveries` ON `order_delivery_id` = `delivery_id`
                LEFT JOIN `products` ON `cart_product_id` = `product_id`
                LEFT JOIN `statuses` ON `order_status_id` = `status_id`
                WHERE `order_user_id` = $userId
                ORDER BY $sortSql;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }


        /**
         * @param int $limit Сколько записией выводить при пагинации
         * @param int $offset С какой записи выводить пагинацию
         * @return array Массив с информацией по каждому заказу для админа
         */
        public function getAllCartsPaginated($limit, $offset)
        {
            $query = "
                SELECT `product_name`, `order_user_id`, `order_address`, `cart_product_count`, `order_id`, `order_registration_time`, `order_delivery_time`, `delivery_name`, `status_name`, `product_price`, `product_sale`, `payment_name`
                FROM `carts`
                LEFT JOIN `orders` ON `cart_order_id` = `order_id`
                LEFT JOIN `payments` ON `order_payment_id` = `payment_id`
                LEFT JOIN `deliveries` ON `order_delivery_id` = `delivery_id`
                LEFT JOIN `products` ON `cart_product_id` = `product_id`
                LEFT JOIN `statuses` ON `order_status_id` = `status_id`
                ORDER BY `order_id` DESC
                LIMIT $offset, $limit;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
