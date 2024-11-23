<?php

    /**
     * Контроллер для CRUD-операций с товарами. Доступен только администраторам
     */
    class ProductController extends BaseController
    {
        /**
         * @var object Модель Product
         */
        private $productModel;

        /**
         * @var object Модель Category
         */
        private $categoryModel;

        /**
         * @var object Модель Manufacturer
         */
        private $manufacturerModel;

        /**
         * Конструктор
         */
        public function __construct()
        {
            parent::__construct();
            $this->categoryModel = new Category();
            $this->manufacturerModel = new Manufacturer();
            $this->productModel = new Product();
        }

        /**
         * @param int $page Номер страницы для пагинации
         *
         * Выводит view с таблицей, в которой находится список товаров
         */
        public function actionIndex($page = 1)
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }

            //Данные для пагинации
            $total = $this->productModel->getTotal();
            $limit = 10;
            $currentPage = $page;
            $index = 'page=';
            $offset = ($page - 1) * $limit;
            $pagination = new Pagination($total, $currentPage, $limit, $index);

            //Список товаров для вывода
            $products = $this->productModel->getAllPaginated($limit, $offset);

            $title = 'Товары';
            include_once ("views/products/table.html");
        }

        /**
         * Добавление нового товара
         */
        public function actionAdd()
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            $errors = [];

            if (isset($_POST['product_name'])) {
                $nameProduct = htmlentities($_POST['product_name']);
                $codeProduct = htmlentities($_POST['product_code']);
                $priceProduct = htmlentities($_POST['product_price']);
                $saleProduct = htmlentities($_POST['product_sale']);
                $categoryProduct = htmlentities($_POST['product_category']);
                $manufacturerProduct = htmlentities($_POST['product_manufacturer']);
                $descriptionProduct = htmlentities($_POST['product_description']);
                $imgProduct = $_FILES['product_img'];
                $imgProductName = $imgProduct['name'];
                $pathImg = LOAD_IMG . $imgProductName;

                //TODO: проверка на регулярки, стирание лишних пробелов, проверка на существование такого товара в БД

                if (!move_uploaded_file($imgProduct['tmp_name'], $pathImg) && !empty($imgProductName)){
                    $errors[] = 'Не удалось загрузить изображение';
                }

                $data = array(
                    'name' => $nameProduct,
                    'code' => $codeProduct,
                    'price' => $priceProduct,
                    'sale' => $saleProduct,
                    'category' => $categoryProduct,
                    'manufacturer' => $manufacturerProduct,
                    'description' => $descriptionProduct,
                    'name_img' => $imgProductName
                );

                //Если валидация пройдена, вносим данные в БД
                if (empty($errors)) {
                    $this->productModel->insert($data);
                    header('Location:' . FULL_SITE_ROOT . 'admin/products');
                }
            }

            //Список производителей для select в форме
            $manufacturers = $this->manufacturerModel->getAll();

            //Список категорий для select в форме
            $categories = $this->categoryModel->getAll();

            $title = 'Добавление товара';
            include_once ("views/products/form.html");
        }

        /**
         * Редактирование товара
         * @param int $id ID товара, который необходимо редактировать
         */
        public function actionEdit($id)
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            $errors = [];
            $product = $this->productModel->getById($id);
            //TODO: проверка, что данные с таким id существуют
            if (isset($_POST['product_name'])) {
                $nameProduct = htmlentities($_POST['product_name']);
                $priceProduct = htmlentities($_POST['product_price']);
                $codeProduct = htmlentities($_POST['product_code']);
                $saleProduct = htmlentities($_POST['product_sale']);
                $categoryProduct = htmlentities($_POST['product_category']);
                $manufacturerProduct = htmlentities($_POST['product_manufacturer']);
                $descriptionProduct = htmlentities($_POST['product_description']);
                $imgProduct = $_FILES['product_img'];
                $imgProductName = $imgProduct['name'];
                $pathImg = LOAD_IMG . $imgProductName;

                //TODO: регулярки

                $data = array(
                    'name' => $nameProduct,
                    'code' => $codeProduct,
                    'price' => $priceProduct,
                    'sale' => $saleProduct,
                    'category' => $categoryProduct,
                    'manufacturer' => $manufacturerProduct,
                    'description' => $descriptionProduct,
                    'name_img' => $imgProductName
                );

                if (!move_uploaded_file($imgProduct['tmp_name'], $pathImg) && !empty($imgProductName)){
                    $errors[] = 'Не удалось загрузить фото';
                }

                if (empty($errors)) {
                    if ($product === $data) {
                        header('Location:' . FULL_SITE_ROOT . 'admin/products');
                    }
                    if ($product !== $data) {
                        //TODO: проверка, что таких данных уже нет в таблице
                        $result = $this->productModel -> edit($data, $id);
                        if ($result) {
                            header('Location:' . FULL_SITE_ROOT . 'admin/products');
                        } else {
                            $errors[] = "Не удалось добавить данные в таблицу";
                        }
                    }
                }
            }
            //Список производителей для select в форме
            $manufacturers = $this->manufacturerModel->getAll();

            //Список категорий для select в форме
            $categories = $this->categoryModel->getAll();

            $title = 'Изменить данные товара';
            include_once ("views/products/form.html");
        }

        /**
         * Удаление товара
         * @param int $id ID товара, который необходимо удалить
         */
        public function actionDelete($id)
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            $errors = [];
            //TODO: проверка, что id передан верно, и он существует
            $this->productModel->remove($id);
            header('Location:' . FULL_SITE_ROOT . 'products');
        }
    }
