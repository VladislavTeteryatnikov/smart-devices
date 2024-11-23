<?php

    class Order
    {
        public $connect;

        public function __construct()
        {
            $this->connect = DB::getConnect();
        }

        public function insert($data)
        {
            $query = "
                INSERT INTO `orders`
                    SET `order_user_id` = $data[userId],
                        `order_address` = '$data[address]',
                        `order_delivery_time` = '$data[date]',
                        `order_payment_id` = $data[payment],
                        `order_delivery_id` = $data[delivery];
            ";
            return mysqli_query($this->connect, $query);
        }

        public function getTotal()
        {
            $query = "
                SELECT COUNT(*) AS `count`
                FROM `orders`;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result)['count'];
        }
    }
