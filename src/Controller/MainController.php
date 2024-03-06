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

        $prodModel = new Product();
        $products = $prodModel->getAll();

        require_once './../View/main.php';
    }
}