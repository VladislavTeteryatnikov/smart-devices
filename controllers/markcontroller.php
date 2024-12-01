<?php

    /**
     * Контроллер для работы с отзывами товаров
     */
    class MarkController extends BaseController
    {
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
            $this->markModel = new Mark();
        }

        /**
         * Добавление отзыва на продукт. Выводит view с формой для написания отзыва
         */
        public function actionAdd()
        {
            $errors = [];
            //Возобновляем сессию и забираем ID товара, на который пользователь хочет оставить отзыв
            session_start();
            $productId = $_SESSION['productId'];
            //Закрываем возможность оставить отзыв, если пользователь не авторизоан, либо если в сессии нет ID товара, на который необходимо оставить отзыв
            if (!$productId){
                header('Location:' . FULL_SITE_ROOT . 'catalog/1');
                die();
            }
            if (!$this->isAuthorized){
                header('Location:' . FULL_SITE_ROOT . 'auth');
                die();
            } else{
                //Обрабатываем форму
                if (isset($_POST['mark'])){
                    $mark = htmlentities($_POST['mark']);
                    $dignities = htmlentities($_POST['dignities']);
                    $disadvantages = htmlentities($_POST['disadvantages']);
                    $comment = htmlentities($_POST['comment']);
                    $userId = json_decode($_COOKIE['uid'], true);
                    $data = array(
                        'mark' => $mark,
                        'dignities' => $dignities,
                        'disadvantages' => $disadvantages,
                        'comment' => $comment,
                        'productId'=> $productId,
                        'userId' => $userId
                    );
                    if (empty($comment)){
                        $errors[] = 'Поле "Комментарий" должно быть заполнено';
                    }
                    //Если все валидно и корректно, то добавляем отзыв в БД
                    if (empty($errors)){
                        $this->markModel->insertMark($data);
                        header('Location:' . FULL_SITE_ROOT . 'item/' . $productId);
                    }
                }
            }

            $title = 'Добавить отзыв';
            include_once("views/marks/mark.html");
        }

    }
