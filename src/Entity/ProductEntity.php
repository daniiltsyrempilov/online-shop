<?php

namespace Entity;

class ProductEntity
{
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private string $imgUrl;

    public function __construct(int $id, string $name, string $description, float $price, string $imgUrl)
    {
        $this->id = $id;
        $this->name= $name;
        $this->description = $description;
        $this->price = $price;
        $this->imgUrl = $imgUrl;

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImage(): string
    {
        return $this->imgUrl;
    }
}