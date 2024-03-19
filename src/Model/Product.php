<?php
namespace Model;

use Entity\ProductEntity;

class Product extends Model
{
    public function getAll(): ProductEntity|null
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();

        if (empty($products)){
            return null;
        }

        $productsArray = [];
        foreach ($products as $product) {
            $productsArray = new ProductEntity($product['id'], $product['name'], $product['description'], $product['price'], $product['img_url']);
        }

        return $productsArray;
    }
}