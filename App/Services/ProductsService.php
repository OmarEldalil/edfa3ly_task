<?php


namespace App\Services;


use App\Models\Product;

class ProductsService
{
    protected array $products =[];

    public function __construct()
    {
        $this->loadProducts();
    }

    private function loadProducts()
    {
        $products = require __DIR__ . '/../Data/products.php';
        foreach ($products as $product => $price) {
            $this->products[] = new Product($product, $price);
        }
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function productsToArray()
    {
        $products = [];
        foreach ($this->products as $product) {
            $products[$product->name] = $product->price;
        }
        return $products;
    }
}
