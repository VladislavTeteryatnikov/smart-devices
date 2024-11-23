<?php

    /**
     * Класс-помощник
     */
    class Helper
    {
        /**
         * Метод для генерации рандомного токена
         * @param int $size Длина генерируемого токена
         * @return string Возварщает токен
         */
        public function generateToken($size = 32)
        {
            //Символы, которые могут содержаться в токене
            $symbols = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g'];
            $symbolsLength = count($symbols);
            //Создаем пустой токен
            $token = "";
            //Записываем в токен рандомные символы из $symbols
            for ($i = 0; $i < $size; $i++) {
                $token .= $symbols[rand(0, $symbolsLength - 1)];
            }
            return $token;
        }

        /**
         * Метод для опредления количества товаров пользователя в корзине
         * @return int Количество товаров в корзине
         */
        public function countingItemsInBasket()
        {
            if (isset($_COOKIE['cart'])) {
                $data = json_decode($_COOKIE['cart'], true);
                $totalItems = 0;
                foreach ($data as $count) {
                    $totalItems += $count;
                }
                return $totalItems;
            }
        }

        /**
         * @param string $title Заголовок для ссылки
         * @param string $a Get-параметр для ссылки
         * @param string $b Get-параметр для ссылки
         * @return string Ссылка для сортировки в html тыблице
         */
        public function sortLinkTh($title, $a, $b)
        {
            isset($_GET['sort']) ? $sort = htmlentities($_GET['sort']) : $sort = null;

            if ($sort == $a) {
                return '<a id="sort" class="" href="?sort=' . $b . '">' . $title . ' <i>▲</i></a>';
            } elseif ($sort == $b) {
                return '<a id="sort" class="" href="?sort=' . $a . '">' . $title . ' <i>▼</i></a>';
            } else {
                return '<a id="sort" href="?sort=' . $a . '">' . $title . '</a>';
            }
        }

    }
