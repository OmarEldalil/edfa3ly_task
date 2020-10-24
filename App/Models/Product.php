<?php


namespace App\Models;


class Product
{
    public string $name;
    public float $price;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function toArray()
    {
        return ['name' => $this->name, 'price' => $this->price];
    }

}
