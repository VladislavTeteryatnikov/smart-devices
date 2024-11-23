<?php

    /**
     * Контроллер для CRUD-операций с категориями товаров. Доступен только администраторам
     */
    class CategoryController extends BaseController
    {
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
            $this->categoryModel = new Category();
        }

        /**
         * @param int $page Номер страницы для пагинации
         *
         * Выводит view с таблицей, в которой находится список категорий товаров
         */
        public function actionIndex($page = 1)
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            //Данные для пагинации
            $total = $this->categoryModel->getTotal();
            $limit = 10;
            $currentPage = $page;
            $index = 'page=';
            $offset = ($page - 1) * $limit;
            $pagination = new Pagination($total, $currentPage, $limit, $index);

            //Список категорий для вывода
            $categories = $this->categoryModel->getAllPaginated($limit, $offset);

            $title = 'Категории';
            include_once ("views/categories/table.html");
        }

        /**
         * Добавление новой категории товаров
         */
        public function actionAdd()
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            $errors = [];
            if (isset($_POST['category_name'])) {
                $nameCategory = htmlentities($_POST['category_name']);
                //TODO: проверка на регулярки
                //TODO: проверка, что таких данных уже нет в таблице

                //Если валидация пройдена, вносим данные в БД
                if (empty($errors)) {
                    $this->categoryModel->insert($nameCategory);
                    header('Location:' . FULL_SITE_ROOT . 'admin/categories');
                }
            }

            $title = 'Добавить категорию';
            include_once ("views/categories/form.html");
        }

        /**
         * Редактирование категории товаров
         * @param int $id ID категории, которую необходимо редактировать
         */
        public function actionEdit($id)
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            $errors = [];
            $category = $this->categoryModel->getById($id);
            if (isset($_POST['category_name'])){
                $nameCategory = htmlentities($_POST['category_name']);
                //TODO: проверка на регулярки
                if (empty($errors)){
                    if ($category['category_name'] === $nameCategory){
                        header('Location:' . FULL_SITE_ROOT . 'admin/categories');
                    }
                    if ($category['category_name'] !== $nameCategory) {
                        //TODO: проверка, что таких данных уже нет в таблице
                        $result = $this->categoryModel->edit($nameCategory, $id);
                        if ($result) {
                            header('Location:' . FULL_SITE_ROOT . 'admin/categories');
                        } else {
                            $errors[] = "Не удалось добавить данные в таблицу";
                        }
                    }
                }
            }

            $title = 'Изменить категорию';
            include_once ("views/categories/form.html");
        }

        /**
         * Удаление категории товаров
         * @param int $id ID категории, которую необходимо удалить
         */
        public function actionDelete($id)
        {
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            $errors = [];
            //TODO: проверка, что id передан верно, и он существует. Возникшие ошибки поместить в массив $errors
            $this->categoryModel->remove($id);
            header('Location:' . FULL_SITE_ROOT . 'admin/categories');
        }

    }
