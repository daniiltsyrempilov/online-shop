<?php

namespace Model;

class OrderProduct extends Model
{
    public function create(int $productId, int $orderId, float $price, int $quantity): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_product (productId, orderId, price, quantity) VALUES (:productId, :orderId, :price, :quantity)");
        $stmt->execute(['productId' => $productId, 'orderId' => $orderId, 'price' => $price, 'quantity' => $quantity]);

    }
}