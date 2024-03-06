<?php

class App
{
    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if ($uri === '/registrate') {
            $reg = new UserController();
            if ($method === 'GET') {
                $reg->getRegistrate();
            } elseif ($method === 'POST') {
                $reg->postRegistrate();
            } else {
                echo "$method не поддерживает $uri";
            }
        } elseif ($uri === '/login') {
            $log = new UserController();
            if ($method === 'GET') {
                $log->getLogin();
            } elseif ($method === 'POST') {
                $log->postLogin();
            } else {
                echo "$method не поддерживает $uri";
            }
        } elseif ($uri === '/main') {
            $main = new MainController();
            if ($method === 'GET') {
                $main->getMain();
            } elseif ($method === 'POST') {
                $addProd = new ProductController();
                $addProd->postAddProduct();
            } else {
                echo "$method не поддерживает $method";
            }
        } elseif ($uri === '/add-product') {
            $addProd = new ProductController();
            if ($method === 'GET') {
                $addProd->getAddProduct();
            } else {
                echo "$method не поддерживает $uri";
            }
        } else {
            require_once "./../View/404.html";
        }
    }
}