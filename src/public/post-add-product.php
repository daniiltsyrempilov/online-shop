<?php

function validate(array $data): array
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

$errors = validate($_POST);

if (empty($errors)) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    session_start();
    $userId = $_SESSION['user_id'];
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login.php");
    } else {

        $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=laravel", 'root', 'root');
        $stmt = $pdo->prepare("INSERT INTO user_products(user_id, product_id, quantity) VALUES(:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }
}

require_once './add-product.php';
