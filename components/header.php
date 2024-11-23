<?php

    /**
     * Класс для формирования шапки сайта
     */
    class Header
    {
        /**
         * @var object Модель Category
         */
        private $categoryModel;

        /**
         * @var object Helper. Класс-помощник
         */
        public $helper;

        /**
         * Конструктор
         */
        public function __construct()
        {
            $this->categoryModel = new Category();
            $this->helper = new Helper();
        }

        /**
         * Получение списка категорий товаров для меню в шапке
         *
         * @return array Список категорий товаров
         */
        public function getCategoriesMenu()
        {
            return $this->categoryModel->getAll();
        }

        /**
         * Получение количества товаров в корзине
         *
         * @return int Количество товаров в корзине
         */
        public function getTotalItems()
        {
            return $this->helper->countingItemsInBasket();
        }
    }
