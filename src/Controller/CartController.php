<?php

class CartController
{
    private UserProduct $userProductModel;
    private Product $productModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
    }

    public function getCart(): void
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header('Location: /login');
        }

        $cart = $this->create($_SESSION['user_id']);
        $totalPrice = $this->totalPrice($_SESSION['user_id']);
        $product = $this->productModel->getAll();

        if (empty($cart)) {
            $notification = 'Корзина пуста';
        }

        require_once './../View/cart.php';
    }

    public function totalPrice($userId): float
    {
        $products = $this->productModel->getAll();
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

    public function create($userId): array
    {
        $products = $this->productModel->getAll();
        $userProducts = $this->userProductModel->getAllByUserId($userId);


        foreach ($userProducts as $userProduct) {
            $productOfCart = [];

            foreach ($products as $product) {
                if ($product['id'] === $userProduct['product_id']) {
                    $productOfCart['name'] = $product['name'];
                    $productOfCart['img_url'] = $product['img_url'];
                    $productOfCart['quantity'] = $userProduct['quantity'];
                    $productOfCart['sum'] = $userProduct['quantity'] * $product['price'];
                }
            }
            $cart[] = $productOfCart;
        }
        return $cart;
    }
}