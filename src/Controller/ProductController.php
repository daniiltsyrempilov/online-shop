<?php

class ProductController
{
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

    public function getAddProduct()
    {
        require_once './../View/add-product.php';
    }

    public function postAddProduct()
    {
        session_start();
        $errors = $this->validate($_POST);

        if (empty($errors)) {
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $userId = $_SESSION['user_id'];

            $userProdModel = new Product();

            if($userProdModel->getOneByUserIdProductId($userId,$productId)) {
                $userProdModel->updateQuantity($userId, $productId, $quantity);
            } else {
                $userProdModel->setUserProdDAta($_POST, $userId);
            }

            $notification  = "Товар успешно добавлен в количестве $quantity шт";

        }

        $prodModel = new Product();
        $products = $prodModel->getAll();
        require_once './../View/main.php';
    }
}