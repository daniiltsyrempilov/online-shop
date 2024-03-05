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
        $errors = $this->validate($_POST);

        if (empty($errors)) {
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            session_start();
            $userId = $_SESSION['user_id'];
            if (!isset($_SESSION['user_id'])) {
                header("Location: /login");
            } else {
                require_once './../Model/Product.php';
                $userProdModel = new Product();
                $userProdModel->setUserProdDAta($_POST, $_SESSION['user_id']);
            }
        }

        require_once './../View/add-product.php';
    }
}