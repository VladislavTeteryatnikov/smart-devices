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
         * Метод, который выводит view 'Корзина'
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

        /**
         * Данный метод больше не нужен, так как переписал его на js
         * Метод устаналивает куки с информацией о товарах в корзине (ID товара и его количество)
         * @param int $productId ID товара, который пользователь добаляет в корзину
         */
        /*public function actionAdd($productId)
        {
            //В куке, отвечающей за корзину лежит массив в формате json. Индекс элемента - ID товара, значение - количество этого товара в корзине.
            //Если кука, отвечающая за корзину есть, то проверяем есть ли в массиве элемент с индексом = ID товара. Если есть, то увеличиваем значение на 1, если нет - создаем новый элемент массива. Если куки нет, то создаем массив. Затем устанавливаем или обновляем куку
            if (isset($_COOKIE['cart'])){
                $data = json_decode($_COOKIE['cart'], true);
                if ( array_key_exists($productId, $data)){
                    $data[$productId]++;
                } else {
                    $data[$productId] = 1;
                }
            } else {
                $data[$productId] = 1;
            }
            setcookie('cart', json_encode($data), time() + 60 * 60 * 24 * 2, '/');
            header('Location:' . FULL_SITE_ROOT . 'item/' . $productId);
        }*/

        /**
         * Метод обновляет куку, отвечающую за корзину, при удалении товара из нее
         * @param int $id ID товара, который нужно удалить из корзины
         */
        /*public function actionDelete($id)
        {
            //Забираем куку, отвечающую за корзину. Если колиство товара с одним ID > 1, то уменьшаем количество этого товара на 1 и обновляем куку. Если товар с таким ID был 1, то удаляем этот элемент из массива. Если массив остается пустым, то куку удаляем, иначе просто обновляем
            if (isset($_COOKIE['cart'])) {
                $data = json_decode($_COOKIE['cart'], true);

                if ($data[$id] > 1) {
                    $data[$id] -= 1;
                    setcookie('cart', json_encode($data), time() + 60 * 60 * 24 * 2, '/');
                } else {
                    unset($data[$id]);
                    if (empty($data)) {
                        setcookie('cart', '', time() - 1000, '/');
                    } else {
                        setcookie('cart', json_encode($data), time() + 60 * 60 * 24 * 2, '/');
                    }
                }
            }

            header('Location:' . FULL_SITE_ROOT . 'cart');
        }*/
    }
