<?php

class ProductController
{
    private UserProduct $userProdModel;
    private Product $productModel;

    public function __construct()
    {
        $this->userProdModel = new UserProduct();
        $this->productModel = new Product();
    }

    public function getAddProduct()
    {
        require_once './../View/add-product.php';
    }

    public function postAddProduct()
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header('Location: /login');
        }
        $errors = $this->validate($_POST);

        $amount = $this->amount($_SESSION['user_id']);

        if (empty($errors)) {
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $userId = $_SESSION['user_id'];

            if(empty($this->userProdModel->getOneByUserIdProductId($userId,$productId))) {
                $this->userProdModel->create($userId, $productId, $quantity);
            } else {
                $this->userProdModel->updateQuantity($userId, $productId, $quantity);
            }
        }

        header('Location: /main');
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (isset($data['product_id'])) {
            $productId = $data['product_id'];

            if (!preg_match("/^[0-9]+$/", $productId)) {
                $errors['product_id'] = 'Некорректный product-id';
            }
        } else {
            $errors['product_id'] = "Заполните поле product_id";
        }

        if (isset($data['quantity'])) {
            $quantity = $data['quantity'];

            if (!preg_match("/^[0-9]+$/", $quantity)) {
                $errors['quantity'] = 'Неккоректный quantity';
            }
        } else {
            $errors['quantity'] = "Заполните поле quantity";
        }

        return $errors;
    }

    public function amount($userId): array
    {
        $products = $this->productModel->getAll();
        $userProducts = $this->userProdModel->getAllByUserId($userId);


        foreach ($userProducts as $userProduct) {
            $productOfCart = [];

            foreach ($products as $product) {
                if ($product['id'] === $userProduct['product_id']) {
                    $productOfCart['quantity'] = $userProduct['quantity'];
                }
            }
            $cart[] = $productOfCart;
        }
        return $cart;
    }
}