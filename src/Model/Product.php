<?php

class Product
{
    public function setUserProdDAta(array $post, int $usID): bool
    {
        $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=laravel", 'root', 'root');

        $userId = $usID;
        $productId = $post['product_id'];
        $quantity = $post['quantity'];

        $stmt = $pdo->prepare("INSERT INTO user_products(user_id, product_id, quantity) VALUES(:user_id, :product_id, :quantity)");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function getAll(): false|array
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=laravel", "root", "root");

        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();

        return $products;
    }
}