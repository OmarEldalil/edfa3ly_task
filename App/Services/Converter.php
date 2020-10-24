<?php


namespace App\Services;


use App\Models\Cart;

class Converter
{
    private array $conversions;

    public function __construct()
    {
        $this->conversions = require __DIR__ . '/../Data/conversions.php';
    }

    public function convert($value, $currency)
    {
        if (in_array($currency, array_keys($this->conversions))) {
            return float2DecimalPlaces($value * $this->conversions[$currency]);
        }
        throw new \Exception('Currency is incorrect or not supported');
    }
}
