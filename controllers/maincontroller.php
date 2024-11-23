<?php
    /**
     * Контроллер, формирующий страницу "Главная" на сайте
     */
    class MainController extends BaseController
    {
        /**
         * @var object Модель Product
         */
        private $productModel;

        /**
         * Конструктор
         */
        public function __construct()
        {
            parent::__construct();
            $this->productModel = new Product();
        }

        /**
         * Выводит view 'Главная'
         */
        public function actionIndex()
        {
            //Товары со скидкой
            $products = $this->productModel->getProductsWithSale();

            $title = "Главная";
            include_once("views/main/main-page.html");
        }
    }
