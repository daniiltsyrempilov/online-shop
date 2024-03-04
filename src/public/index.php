<?php


#print_r($_SERVER);

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/registrate') {
    if ($method === 'GET') {
        require_once './registrate.php';
    } elseif ($method === 'POST') {
        require_once './post-registrate.php';
    } else {
        echo "$method не поддерживает $uri";
    }
} elseif ($uri === '/login') {
    if ($method === 'GET') {
        require_once './login.php';
    } elseif ($method === 'POST') {
        require_once './post-login.php';
    } else {
        echo "$method не поддерживает $uri";
    }
} elseif ($uri === '/main') {
    if ($method === 'GET') {
        require_once './main.php';
    } else {
        echo "$method не поддерживает $method";
    }
} elseif ($uri === '/add-product') {
    if ($method === 'GET') {
        require_once './add-product.php';
    } elseif ($method === 'POST') {
        require_once './post-add-product.php';
    } else {
        echo "$method не поддерживает $uri";
    }
} else {
    require_once "./404.html";
}

