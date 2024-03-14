<?php

namespace Model;

class Order extends Model
{
    public function create(string $firstname, string $lastname, int $phoneNumder, string $email, string $address): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (firstname, lastname, phone_number, email, address) VALUES (:firstname, :lastname, :phone_number, :email, :address)");
        $stmt->execute(['firstname' => $firstname, 'lastname' => $lastname, 'phone_number' => $phoneNumder, 'email' => $email, 'address' => $address]);

    }
}