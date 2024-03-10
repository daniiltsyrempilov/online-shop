<?php

class UserProduct extends Model
{
    public function create(string $userId, string $productId, string $quantity): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products(user_id, product_id, quantity) VALUES(:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function updateQuantity($userId, $productId, $quantity): void
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET quantity = (quantity + :quantity) WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$userId, 'product_id'=>$productId, 'quantity'=>$quantity]);
    }

    public function getOneByUserIdProductId($userId, $productId)
    {
        $stmt = $this->pdo->prepare("SELECT user_id, product_id FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$userId, 'product_id'=>$productId]);
        $userProduct = $stmt->fetch();

        return $userProduct;
    }

    public function getAllByUserId($userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}