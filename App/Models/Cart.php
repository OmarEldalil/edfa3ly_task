<?php

namespace App\Models;

use App\App;
use App\Services\OffersService;
use App\Traits\Formatable;

class Cart
{
    use Formatable;

    public array $productNames = [];
    public array $cartItems = [];
    private array $products = [];
    private float $subTotal = 0;
    private float $tax = 0;
    private float $total = 0;
    private array $discounts = [];
    private string $currency;
    private bool $includeOffers;

    public function __construct($productNames)
    {
        $this->productNames = $productNames;
        $this->products = App::get()->productsService->productsToArray();
        $this->currency = isset(app()->config['default_currency']) ? app()->config['default_currency'] : 'USD';
        $this->includeOffers = isset(app()->config['include_offers']) ? app()->config['include_offers'] : false;
    }

    public function prepare()
    {
        return $this->loadCartItems()->calculateCost();
    }

    private function calculateCost()
    {
        $this->calculateSubTotal();
        $this->calculateTax();
        if ($this->includeOffers) {
            $this->calculateTotalDiscounts();
        }
        $this->calculateTotal();
        return $this;
    }

    public function calculateSubTotal()
    {
        $subTotal = 0;
        foreach ($this->cartItems as $cartItem => $quantity) {
            $subTotal += $this->products[$cartItem] * $quantity;
        }
        $this->subTotal = ($subTotal);
        return $this->subTotal;
    }

    public function calculateTax()
    {
        if (!$this->subTotal) {
            $this->calculateSubTotal();
        }
        $taxRatio = isset(\app()->config['tax']) ? \app()->config['tax'] : 0.14;
        $this->tax = ($this->subTotal * $taxRatio);
        return $this->tax;
    }

    private function calculateTotalDiscounts()
    {
        $offerService = new OffersService();
        $this->discounts = $offerService->applyAvailableOffers($this);
        return $this->discounts;
    }

    public function calculateTotal()
    {
        $total = $this->getSubTotal() + $this->getTax() - $this->getTotalDiscounts();
        $this->total = float2DecimalPlaces($total);
        return $this->total;
    }

    /**
     * @return float
     */
    public function getSubTotal(): float
    {
        return $this->subTotal;
    }

    /**
     * @return float
     */
    public function getTax(): float
    {
        return $this->tax;
    }

    private function getTotalDiscounts()
    {
        $totalDiscounts = 0;
        foreach ($this->discounts as $discount) {
            $totalDiscounts += $discount['discount'];
        }
        return $totalDiscounts;
    }

    public function loadCartItems()
    {
        $productsNames = array_keys($this->products);
        foreach ($this->productNames as $productName) {
            if (in_array($productName, $productsNames)) {
                $this->cartItems[$productName] = isset($this->cartItems[$productName]) ? $this->cartItems[$productName] + 1 : 1;
            } else {
                throw new \Exception("Product $productName is Not found");
            }
        }
        return $this;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    public function convertCurrency($convertToCurrency = null)
    {
        $this->currency = $convertToCurrency ?? $this->currency;
        foreach ($this->amounts() as $amount => $value) {
            $this->$amount = \app()->converter->convert($value, $this->currency);
        }
        foreach ($this->discounts as $index => $discount) {
            $this->discounts[$index]['discount'] = \app()->converter->convert($discount['discount'], $this->currency);
        }
    }

    private function amounts()
    {
        return [
            'subTotal' => $this->subTotal,
            'tax' => $this->tax,
            'total' => $this->total,
        ];
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
