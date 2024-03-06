<?php
require_once 'Model.php';

class Product extends Model
{
    public function setUserProdDAta(array $post, int $usID): bool
    {


        $userId = $usID;
        $productId = $post['product_id'];
        $quantity = $post['quantity'];

        $stmt = $this->pdo->prepare("INSERT INTO user_products(user_id, product_id, quantity) VALUES(:user_id, :product_id, :quantity)");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function getAll(): false|array
    {


        $stmt = $this->pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();

        return $products;
    }

    public function updateQuantity($user_id, $product_id, $quantity)
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET quantity = (quantity + :quantity) WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id, 'quantity'=>$quantity]);
    }

    public function getOneByUserIdProductId($user_id, $product_id)
    {
        $stmt = $this->pdo->prepare("SELECT user_id, product_id FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id]);
        $userProduct = $stmt->fetch();

        return $userProduct;
    }
}