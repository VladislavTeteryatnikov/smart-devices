<?php

    /**
     * Контроллер, формирующий страницу Каталога с определенной категорией товаров
     */
     class CatalogController extends BaseController
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
          * Конструктор
          */
         public function __construct()
         {
             parent::__construct();
             $this->productModel = new Product();
             $this->categoryModel = new Category();
         }

         /**
          * Выводит view с определенной категориев товаров в каталоге
          * @param int $categoryId ID категории товаров
          * @param int $page Номер страницы, с которой начинается пагинация
          */
         public function actionIndex($categoryId, $page = 1)
         {
             //TODO: сделать валидацию $categoryId
             //Проверка, что категория с переданным id существует, иначе 404
             $category = $this->categoryModel->getById($categoryId);
             if (!$category) {
                 header("HTTP/1.0 404 Not Found");
                 header("HTTP/1.1 404 Not Found");
                 header("Status: 404 Not Found");
                 exit();
             }

             //Данные для пагинации
             $total = $this->productModel->getCountByCategoryId($categoryId);
             $limit = 9;
             $currentPage = $page;
             $index = 'page=';
             $offset = ($page - 1) * $limit;
             $pagination = new Pagination($total, $currentPage, $limit, $index);

             //Список товаров определенной категории
             $products = $this->productModel->getAllPaginatedByCategoryId($limit, $offset, $categoryId);

             //Данные для отображения секции фильтров (производитель и цены)
             $manufacturersForCheckbox = array_unique(array_column($products, 'manufacturer_name'));
             $prices = array_column($products, 'product_price');
             $priceMin = min($prices);
             $priceMax = max($prices);

             //Фильтры по цене
             if (isset($_GET['pfrom'])) {
                 $pricesFilter['priceFrom'] = htmlentities($_GET['pfrom']);
                 $pricesFilter['priceTo'] = htmlentities($_GET['pto']);

                //Фильтр по производителям (checkbox)
                if (isset($_GET['manufacturer'])) {
                    $manufacturersFilter = $_GET['manufacturer'];
                } else{
                    $manufacturersFilter = array();
                }
                 //Список товаров с учетом фильтров
                 $products = $this->productModel->getAllPaginatedByCategoryIdByFilter($limit, $offset, $categoryId, $manufacturersFilter, $pricesFilter);
             }

             //Если ничего не нашли
             if(!$products){
                 $nothingFound = 'Ничего не нашли';
             } else {
                 $nothingFound = null;
             }

             $title = 'Каталог';
             include_once("views/catalogs/catalog.html");
         }
     }
