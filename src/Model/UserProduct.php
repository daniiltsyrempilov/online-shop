<?php
namespace Model;

use Entity\ProductEntity;
use Entity\UserEntity;
use Entity\UserProductEntity;

class UserProduct extends Model
{
    public function create(string $userId, string $productId, string $quantity): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products(user_id, product_id, quantity) VALUES(:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function updateQuantityPlus($userId, $productId, $quantity): void
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET quantity = (quantity + :quantity) WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$userId, 'product_id'=>$productId, 'quantity'=>$quantity]);
    }

    public function getOneByUserIdProductId($userId, $productId): UserProductEntity|null
    {
        #$stmt = $this->pdo->prepare("SELECT user_id, product_id FROM user_products WHERE user_id = :user_id AND product_id = :product_id");

        $stmt = $this->pdo->prepare("SELECT up.id AS id, u.id AS user_id, u.name AS user_name, u.email, u.password, 
        p.id AS product_id, p.name AS product_name, p.price, p.description, p.img_url, up.quantity 
        FROM user_products up
        JOIN users u ON up.user_id = u.id
        JOIN products p ON up.product_id = p.id
        WHERE u.id = :user_id AND p.id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);

        $userProduct = $stmt->fetch();

        if (empty($userProduct)) {
            return null;
        }

        #return new UserProductEntity($userProduct['id'], $userProduct['user_id'], $userProduct['product_id'], $userProduct['quantity'],);
        return new UserProductEntity($userProduct['id'],
            new UserEntity($userProduct['user_id'],$userProduct['user_name'],$userProduct['email'],$userProduct['password']),
            new ProductEntity($userProduct['product_id'],$userProduct['product_name'],$userProduct['description'],$userProduct['price'],$userProduct['img_url']),
            $userProduct['quantity']);
    }

    public function getAllByUserId($userId): UserProductEntity|null
    {
        #$stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");

        $stmt = $this->pdo->prepare("SELECT up.id AS id, u.id AS user_id, u.name AS user_name, u.email, u.password, 
        p.id AS product_id, p.name AS product_name, p.price, p.description, p.img_url, up.quantity 
        FROM user_products up
        JOIN users u ON up.user_id = u.id
        JOIN products p ON up.product_id = p.id
        WHERE u.id = :user_id;");

        $stmt->execute(['user_id' => $userId]);

        $userProduct = $stmt->fetchAll();

        if (empty($userProduct)) {
            return null;
        }

        #return new UserProductEntity($userProduct['id'], $userProduct['user_id'], $userProduct['product_id'], $userProduct['quantity']);
        return new UserProductEntity($userProduct['id'],
            new UserEntity($userProduct['user_id'],$userProduct['user_name'],$userProduct['email'],$userProduct['password']),
            new ProductEntity($userProduct['product_id'],$userProduct['product_name'],$userProduct['description'],$userProduct['price'],$userProduct['img_url']),
            $userProduct['quantity']);
    }

    public function remove(string $userId, string $productId): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function updateQuantityMinus($userId, $productId, $quantity): void
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET quantity = (quantity - :quantity) WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$userId, 'product_id'=>$productId, 'quantity'=>$quantity]);
    }

    public function getAll($userId): UserProductEntity|null
    {
        #$stmt = $this->pdo->query('SELECT * FROM user_products WHERE user_id = :user_id');

        $stmt = $this->pdo->prepare("SELECT up.id AS id, u.id AS user_id, u.name AS user_name, u.email, u.password, 
        p.id AS product_id, p.name AS product_name, p.price, p.description, p.img_url, up.quantity 
        FROM user_products up
        JOIN users u ON up.user_id = u.id
        JOIN products p ON up.product_id = p.id
        WHERE u.id = :user_id;");

        $stmt->execute(['user_id' => $userId]);

        $userProduct = $stmt->fetchAll();

        if (empty($userProduct)) {
            return null;
        }

        #return new UserProductEntity($userProduct['id'], $userProduct['user_id'], $userProduct['product_id'], $userProduct['quantity'],);
        return new UserProductEntity($userProduct['id'],
            new UserEntity($userProduct['user_id'],$userProduct['user_name'],$userProduct['email'],$userProduct['password']),
            new ProductEntity($userProduct['product_id'],$userProduct['product_name'],$userProduct['description'],$userProduct['price'],$userProduct['img_url']),
            $userProduct['quantity']);
    }
}