<?php

namespace Core;

use Controller\CartController;
use Controller\MainController;
use Controller\ProductController;
use Controller\UserController;
use Controller\OrderController;

class App
{
    private array $routes = [
        '/registrate' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getRegistrate'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'postRegistrate'
            ],
        ],
        '/login' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getLogin'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'postLogin'
            ],
        ],
        '/logout' => [
            'POST' => [
                'class' => UserController::class,
                'method' => 'logout'
            ],
        ],
        '/main' => [
            'GET' => [
                'class' => MainController::class,
                'method' => 'getMain'
            ],
            'POST' => [
                'class' => ProductController::class,
                'method' => 'postAddProduct'
            ],
        ],
        '/add-product' => [
            'GET' => [
                'class' => ProductController::class,
                'method' => 'getAddProduct'
            ],
        ],
        '/rm-product' => [
            'POST' => [
                'class' => ProductController::class,
                'method' => 'removeProduct'
            ],
        ],
        '/cart' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'getCart'
            ],
        ],
        '/order' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getOrder'
            ],
            'POST' => [
                'class' => OrderController::class,
                'method' => 'postOrder'
            ],
        ],
        '/rere' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'rere'
            ]
        ]
    ];

    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (isset($this->routes[$uri])) {
            $routeMethods = $this->routes[$uri];
            $routeMethod = $_SERVER['REQUEST_METHOD'];

            if (isset($routeMethods[$routeMethod])) {
                $handler = $routeMethods[$routeMethod];
                $class = $handler['class'];
                $method = $handler['method'];

                $obj = new $class;
                $obj->$method($_POST);
            } else {
                echo "$routeMethod не поддерживается для адреса $uri!";
            }
        } else {
            require_once './../View/404.html';
        }
    }

}

