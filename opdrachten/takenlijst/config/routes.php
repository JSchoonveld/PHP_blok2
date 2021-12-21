<?php

use core\Route;

$this->configured_routes =
    [
        #routes for categories

        new Route(
            'GET',
            '/category/index',
            '\app\controllers\CategoryController',
            'index'
        ),
        new Route(
            'GET',
            '/category/([1-9][0-9]*)',
            '\app\controllers\CategoryController',
            'edit'
        ),
        new Route(
            'GET',
            '/category/create',
            '\app\controllers\CategoryController',
            'create'
        ),
        new Route(
            'GET',
            '/category/([1-9][0-9]*)/delete',
            '\app\controllers\CategoryController',
            'confirmDelete'
        ),
        new Route(
            'POST',
            '/category/([1-9][0-9]*)/delete',
            '\app\controllers\CategoryController',
            'delete'
        ),
        new Route(
            'POST',
            '/category/create',
            '\app\controllers\CategoryController',
            'store'
        ),
    ];


