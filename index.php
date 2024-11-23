<?php
    //При переходе по любому url происходит редирект на этот файл
    //Подключаем автозагрузку классов и константы
    require_once("components/autoload.php");
    require_once ("configs/constants.php");

    //При переходе на сайт создается объект приложения и запускается
    $router = new Router();
    $router->run();
