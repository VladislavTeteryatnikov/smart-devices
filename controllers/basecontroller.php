<?php
    /**
     * Базовай контроллер, в котором устанавливаются зависимости, необходимые во всех остальных контроллерах
     */

    class BaseController
    {
        /**
         * @var object объект Header для формирования шапки сайта
         */
        public $headerInfo;

        /**
         * @var array Массив с категориями для вывода меню 'Каталог' в шапке сайта
         */
        public $categoriesMenu;

        /**
         * @var int Количество товаров пользователя в корзине
         */
        public $totalItems;

        /**
         * @var object Модель User
         */
        public $userModel;

        /**
         * @var bool Информация авторизован ли пользователь
         */
        public $isAuthorized;

        /**
         * @var bool Информация есть ли у пользователя права администратора
         */
        public $isAdmin = false;

        /**
         * @var object Errors Объект для вывода ошибок пользователя
         */
        public $checkErrors;

        /**
         * Конструктор
         */
        public function __construct()
        {
            $this->headerInfo = new Header();
            $this->categoriesMenu = $this->headerInfo->getCategoriesMenu();
            $this->totalItems = $this->headerInfo->getTotalItems();

            $this->userModel = new User();
            $this->isAuthorized = $this->userModel->checkIfUserAuthorized();
            $this->isAdmin = $this->userModel->checkIfUserAdmin();

            $this->checkErrors = new Errors();
        }

    }
