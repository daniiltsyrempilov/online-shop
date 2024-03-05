<?php

class MainController
{
    public function getMain()
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header('Location: /login');
        }

        require_once './../Model/Product.php';
        $prodModel = new Product();
        $products = $prodModel->getAll();

        if(empty($products))
        {
            echo 'There are no products';
            die;
        }

        require_once './../View/main.php';
    }
}