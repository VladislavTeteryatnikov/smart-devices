<?php

    /**
     * Контроллер, формирующий страницу конретного товара
     */
    class ItemController extends BaseController
    {
        /**
         * @var object Модель Product
         */
        private $productModel;

        /**
         * @var object Модель Mark
         */
        private $markModel;


        /**
         * Конструктор
         */
        public function __construct()
        {
            parent::__construct();
            $this->productModel = new Product();
            $this->markModel = new Mark();
        }

        /**
         * Выводит view определенного товара
         * @param int $productId ID товара
         */
        public function actionIndex($productId)
        {
            //TODO: сделать валидацию $productId
            //Проверка, что товар с переданным id существует, иначе 404
            $product = $this->productModel->getById($productId);
            if (!$product) {
                header("HTTP/1.0 404 Not Found");
                header("HTTP/1.1 404 Not Found");
                header("Status: 404 Not Found");
                exit();
            }
            //Запускаем сессию. Кладем в сессию id товара, который потребуется при добавлении отзыва
            session_start();
            $_SESSION['productId'] = $productId;

            //Информация о товаре
            $product = $this->productModel->getById($productId);
            //Многомерный массив с оценками и прочей информацией для этого товара
            $marksByProductId = $this->markModel->getByProductId($productId);
            //Колмчество оценок для этого товара
            $countMarksByProductId = $this->markModel->getCountByProductId($productId);
            //Средняя оценка этого товара
            $avgCountByProductId = $this->markModel->getAvgByProductId($productId);
            //Забираем из массива и округляем
            $avgCountByProductId = round($avgCountByProductId['avg'], 1);
            //Многомерный массив с данными: оценка и сколько раз ее поставили
            $groupsMark = $this->markModel->groupByValue($productId);
            //Определяем в % сколько раз поставили каждую оценку по отношению к общему числу оценок товара
            foreach ($groupsMark as $group){
                switch ($group['mark_value']){
                    case 5:
                        $mark5 = ($group['count'] / $countMarksByProductId['count']) * 100;
                        break;
                    case 4:
                        $mark4 = ($group['count'] / $countMarksByProductId['count']) * 100;
                        break;
                    case 3:
                        $mark3 = ($group['count'] / $countMarksByProductId['count']) * 100;
                        break;
                    case 2:
                        $mark2 = ($group['count'] / $countMarksByProductId['count']) * 100;
                        break;
                    case 1:
                        $mark1 = ($group['count'] / $countMarksByProductId['count']) * 100;
                        break;
                }
            }

            $errors = [];
            $title = $product['product_name'];
            include_once("views/items/item.html");
        }


    }
