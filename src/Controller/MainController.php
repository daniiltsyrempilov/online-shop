<?php

class MainController
{
    private Product $prodModel;

    public function __construct()
    {
        $this->prodModel = new Product();
    }
    public function getMain()
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header('Location: /login');
        }

        $products = $this->prodModel->getAll();

        require_once './../View/main.php';
    }
}