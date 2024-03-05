<?php


#print_r($_SERVER);

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/registrate') {
    require_once './../Controller/UserController.php';
    $reg = new UserController();
    if ($method === 'GET') {
        $reg->getRegistrate();
    } elseif ($method === 'POST') {
        $reg->postRegistrate();
    } else {
        echo "$method не поддерживает $uri";
    }
} elseif ($uri === '/login') {
    require_once './../Controller/UserController.php';
    $log = new UserController();
    if ($method === 'GET') {
        $log->getLogin();
    } elseif ($method === 'POST') {
        $log->postLogin();
    } else {
        echo "$method не поддерживает $uri";
    }
} elseif ($uri === '/main') {
    require_once './../Controller/MainController.php';
    $main = new MainController();
    if ($method === 'GET') {
        $main->getMain();
    } else {
        echo "$method не поддерживает $method";
    }
} elseif ($uri === '/add-product') {
    require_once './../Controller/ProductController.php';
    $addProd = new ProductController();
    if ($method === 'GET') {
        $addProd->getAddProduct();
    } elseif ($method === 'POST') {
        $addProd->postAddProduct();
    } else {
        echo "$method не поддерживает $uri";
    }
} else {
    require_once "./../View/404.html";
}

