<?php

    /**
     * Контроллер, формирующий страницу "О компании" на сайте
     */
    class AboutController extends BaseController
    {
        /**
         * Выводит view 'О компании'
         */
        public function actionIndex()
        {
            $title = 'О компании';
            include_once("views/about/about.html");
        }
    }
