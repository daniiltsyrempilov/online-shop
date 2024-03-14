<?php
namespace Controller;

use Model\Product;
use Model\UserProduct;

class MainController
{
    private Product $prodModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->prodModel = new Product();
        $this->userProductModel = new UserProduct();

    }
    public function getMain()
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header('Location: /login');
        }

        $products = $this->prodModel->getAll();
        $quantityProducts = $this->totalPrice($_SESSION['user_id']);

        require_once './../View/main.php';
    }

    public function totalPrice($userId): float
    {
        $products = $this->prodModel->getAll();
        $userProducts = $this->userProductModel->getAllByUserId($userId);
        $totalPrice = 0;

        foreach ($userProducts as $userProduct) {
            $productOfCart = [];
            foreach ($products as $product) {
                if ($product['id'] === $userProduct['product_id']) {
                    $productOfCart['sum'] = $userProduct['quantity'] * $product['price'];
                    $totalPrice += $productOfCart['sum'];
                }
            }
            $totalAmount = $totalPrice;
        }
        return $totalAmount;
    }
}