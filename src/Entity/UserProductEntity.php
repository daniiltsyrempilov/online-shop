<?php

namespace Entity;

class UserProductEntity
{
    private int $id;
    private UserEntity $user;
    private ProductEntity $product;
    private int $quantity;

    public function __construct(int $id, UserEntity $user, ProductEntity $product, int $quantity)
    {
        $this->id = $id;
        $this->user = $user;
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): UserEntity
    {
        return $this->user;
    }

    public function getProduct(): ProductEntity
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }


}