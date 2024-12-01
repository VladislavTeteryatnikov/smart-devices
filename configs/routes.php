<?php

    $routes = array (
        'CatalogController' => array(
            'catalog/([0-9]+)/page=([0-9]+)' => 'index/$1/$2',
            'catalog/([0-9]+)' => 'index/$1'
        ),
        'AboutController' => array(
            'about' => 'index'
        ),
        'ItemController' => array(
            'item/([0-9]+)' => 'index/$1'
        ),
        'CartController' => array(
            'cart/delete/([0-9]+)' => 'delete/$1',
            'cart/add/([0-9]+)' => 'add/$1',
            'cart' => 'index'
        ),
        'OrderController' => array(
            'admin/orders/page=([0-9]+)' => 'show/$1',
            'admin/orders' => 'show',
            'orders' => 'index'
        ),
        'MarkController' => array(
            'mark/add' => 'add'
        ),
        'ManufacturerController' => array (
            'admin/manufacturer/add' => 'add',
            'admin/manufacturer/edit/([0-9]+)' => 'edit/$1',
            'admin/manufacturer/delete/([0-9]+)' => 'delete/$1',
            'admin/manufacturers/page=([0-9]+)' => 'index/$1',
            'admin/manufacturers' => 'index'
        ),
        'UserController' => array(
            'reg' => 'reg',
            'auth' => 'auth',
            'logout' => 'logout',
            'admin/user/edit/([0-9]+)' => 'edit/$1',
            'admin/user/delete/([0-9]+)' => 'delete/$1',
            'admin/users/page=([0-9]+)' => 'index/$1',
            'admin/users' => 'index'
        ),
        'ProductController' => array(
            'admin/product/add' => 'add',
            'admin/product/edit/([0-9]+)' => 'edit/$1',
            'admin/product/delete/([0-9]++)' => 'delete/$1',
            'admin/products/page=([0-9]+)' => 'index/$1',
            'admin/products' => 'index'
        ),
        'CategoryController' => array(
            'admin/category/add' => 'add',
            'admin/category/edit/([0-9]+)' => 'edit/$1',
            'admin/category/delete/([0-9]+)' => 'delete/$1',
            'admin/categories/page=([0-9]+)' => 'index/$1',
            'admin/categories' => 'index'
        ),
        'MainController' => array(
            '' => 'index'
        )
    );
