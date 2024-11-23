<?php

    /**
     * Контроллер для работы с заказами пользователей
     */
    class OrderController extends BaseController
    {
        /**
         * @var object Модель Order
         */
        private $orderModel;

        /**
         * @var object Модель Cart (корзина)
         */
        private $cartModel;

        /**
         * @var object Модель Product
         */
        private $productModel;

        /**
         * @var object Helper Класс-помощник
         */
        private $helper;

        /**
         * Конструктор
         */
        public function __construct()
        {
            parent::__construct();
            $this->orderModel = new Order();
            $this->cartModel = new Cart();
            $this->productModel = new Product();
            $this->helper = new Helper();
        }

        /**
         * Выводит view с заказми конкретного пользователя в личном кабинете
         */
        public function actionIndex()
        {
            //Проверка, что пользователь авторизован
            if (!$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            //Получаем массив оформленных заказов пользователем
            $userId = $_COOKIE['uid'];
            $carts = $this->cartModel->getCartsByUserId($userId);

            //Данные для отображения таблицы с заказми
            $countCarts = count($carts);
            $rowSpanStart = 0;
            $rowSpanEnd = -1;

            //Сортировка таблицы
            $sortList = array(
                'id_asc' => '`order_id`',
                'id_desc' => '`order_id` DESC'
            );

            //Сортировка по № заказа
            if (isset($_GET['sort'])) {
                $sort = htmlentities($_GET['sort']);

                if (array_key_exists($sort, $sortList)) {
                    $sortSql = $sortList[$sort];
                } else {
                    $sortSql = reset($sortList);
                }

                $carts = $this->cartModel->getCartsByUserIdSort($userId, $sortSql);
            }


            $title = "Мои заказы";
            include_once("views/orders/orders.html");
        }

        /**
         * Выводит view с таблицей, в которой находится список всех заказов всех пользователей. Данные для администратора
         * @param int $page Номер страницы для пагинации
         */
        public function actionShow($page = 1)
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            //Данные для пагинации
            $total = $this->orderModel->getTotal();
            $limit = 10;
            $currentPage = $page;
            $index = 'page=';
            $offset = ($page - 1) * $limit;
            $pagination = new Pagination($total, $currentPage, $limit, $index);

            //Список заказов для вывода
            $orders = $this->cartModel->getAllCartsPaginated($limit, $offset);
            $carts = $this->cartModel->getAllCartsPaginated($limit, $offset);

            //Данные для таблицы
            $countCarts = count($orders) - 1;
            $rowSpanStart = 0;
            $rowSpanEnd = -1;

            $title = "Заказы";
            include_once("views/orders/table.html");
        }

    }
