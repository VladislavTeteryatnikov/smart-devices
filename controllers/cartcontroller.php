<?php

    /**
     * Контроллер для работы с корзиной товаров пользовтеля
     */
    class CartController extends BaseController
    {
        /**
         * @var object Модель Product
         */
        private $productModel;

        /**
         * @var object Модель Order
         */
        private $orderModel;

        /**
         * @var object Модель Cart
         */
        private $cartModel;

        /**
         * Конструктор
         */
        public function __construct()
        {
            parent::__construct();
            $this->productModel = new Product();
            $this->orderModel = new Order();
            $this->cartModel = new Cart();
        }

        /**
         * Выводит view 'Корзина'
         */
        public function actionIndex()
        {
            //Забираем куку, отвечающую за корзину. Рассчитываем итоговую стоимость, скидку и количество товаров в корзине
            if (isset($_COOKIE['cart'])) {
                $data = json_decode($_COOKIE['cart'],true);
                $productsCart = $this->productModel->getProductForCart($data);
                $totalPrice = 0;
                $totalSale = 0;
                foreach ($productsCart as $productCart){
                    $totalPrice += $productCart['product_price'] * $data[$productCart['product_id']];
                    $totalSale += $productCart['product_sale'] * $data[$productCart['product_id']];
                }
                //Итоговая сумма заказа
                $totalCost = $totalPrice - $totalSale;
                //Количество товаров в корзине
                $totalItems = $this->headerInfo->getTotalItems();

                if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                     echo json_encode($productsCart);
                     die();
                }

            }

            //Оформление заказа в корзине
            if (isset($_POST['delivery']) && $this->isAuthorized) {
                $delivery = htmlentities($_POST['delivery']);
                $payment = htmlentities($_POST['payment']);
                $address = htmlentities($_POST['address-delivery']);
                $date = htmlentities($_POST['date-delivery']);
                $userId = htmlentities($_COOKIE['uid']);
                $dataItems = json_decode($_COOKIE['cart'], true);

                $data = array(
                    'delivery' => $delivery,
                    'payment' => $payment,
                    'address' => $address,
                    'date' => $date,
                    'userId' => $userId,
                );

                //Вносим данные в таблицу 'orders'
                $this->orderModel->insert($data);
                $orderId = mysqli_insert_id($this->orderModel->connect);
                //Вносим данные в таблицу 'carts'
                $this->cartModel->insert($dataItems, $orderId);
                setcookie('cart', '', time() - 10, '/');
                header('Location:' . FULL_SITE_ROOT . 'orders');

            } elseif (isset($_POST['delivery']) && !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }

            $title = "Корзина";
            include_once("views/carts/cart.html");
        }

    }
