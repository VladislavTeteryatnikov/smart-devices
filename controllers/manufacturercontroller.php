<?php

    /**
     * Контроллер для CRUD-операций с производителями товаров. Доступен только администраторам
     */
    class ManufacturerController extends BaseController
    {
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
            $this->manufacturerModel = new Manufacturer();
        }

        /**
         * Выводит view с таблицей, в которой находится список производителей товаров
         * @param int $page Номер страницы для пагинации
         */
        public function actionIndex($page = 1)
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            //Данные для пагинации
            $total = $this->manufacturerModel->getTotal();
            $limit = 10;
            $currentPage = $page;
            $index = 'page=';
            $offset = ($page - 1) * $limit;
            $pagination = new Pagination($total, $currentPage, $limit, $index);

            //Список производителей для вывода
            $manufacturers = $this->manufacturerModel->getAllPaginated($limit, $offset);

            $title = 'Производители';
            include_once("views/manufacturers/table.html");
        }

        /**
         * Добавление нового производителя товаров
         */
        public function actionAdd()
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            $errors = [];
            if (isset($_POST['name_manufacturer'])) {
                $nameManufacturer = htmlentities($_POST['name_manufacturer']);
                //TODO: проверка на регулярки
                //TODO: проверка, что таких данных уже нет в таблице. Ошибки кладем в массив $errors
                //Если валидация пройдена, вносим данные в БД
                if (empty($errors)) {
                    $this->manufacturerModel->insert($nameManufacturer);
                    header('Location:' . FULL_SITE_ROOT . 'admin/manufacturers');
                }
            }

            $title = 'Добавить производителя';
            include_once("views/manufacturers/form.html");
        }

        /**
         * Редактирование производителя товаров
         * @param int $id ID производителя, которого необходимо редактировать
         */
        public function actionEdit($id)
        {
            //Проверка, что пользователь имеет права администратора
            if (!$this->isAdmin || !$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            }
            $errors = [];
            $manufacturer = $this->manufacturerModel->getById($id);

            if (isset($_POST['name_manufacturer'])) {
                $nameManufacturer = htmlentities($_POST['name_manufacturer']);
                //TODO: проверка на регулярки. Ошибки кладем в $errors
                if (empty($errors)) {
                    if ($manufacturer['manufacturer_name'] === $nameManufacturer) {
                        header('Location:' . FULL_SITE_ROOT . 'admin/manufacturers');
                    }
                    if ($manufacturer['manufacturer_name'] !== $nameManufacturer) {
                        //TODO: проверка, что таких данных уже нет в таблице
                        $result = $this->manufacturerModel -> edit($nameManufacturer, $id);
                        if ($result) {
                            header('Location:' . FULL_SITE_ROOT . 'admin/manufacturers');
                        } else {
                            $errors[] = "Не удалось добавить данные в таблицу";
                        }
                    }

                }
            }
            $title = 'Изменить данные производителя';
            include_once("views/manufacturers/form.html");
        }

        /**
         * Удаление производителя товаров
         * @param int $id ID производителя, которого необходимо удалить
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
                $this->manufacturerModel->remove($id);
                header('Location:' . FULL_SITE_ROOT . 'admin/manufacturers');
        }

    }
