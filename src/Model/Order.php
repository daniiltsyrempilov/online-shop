<?php

namespace Model;

class Order extends Model
{
    public function create(string $userId, string $firstname, string $lastname, int $phoneNumder, string $email, string $address): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, firstname, lastname, phone_number, email, address) VALUES (:user_id, :firstname, :lastname, :phone_number, :email, :address)");
        $stmt->execute(['user_id' => $userId, 'firstname' => $firstname, 'lastname' => $lastname, 'phone_number' => $phoneNumder, 'email' => $email, 'address' => $address]);

    }

    public function getByUserId(string $userId): mixed
    {

        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id=:user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch();
    }

    public function getOrderId(): string
    {
        return $this->pdo->lastInsertId();
    }
}