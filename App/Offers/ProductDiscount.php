<?php


namespace App\Offers;


use App\Models\Cart;

class ProductDiscount implements OfferInterface
{
    private Cart $cart;

    // if the value is less than one (value =< 1) then it's percentage discount
    // if more that 0.1 (value > 1) then it's amount discount "in USD"
    private array $eligibleProducts = ['Shoes' => 0.1];

    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    public function isEligible(): bool
    {
        foreach ($this->cart->cartItems as $cartItem => $quantity) {
            if (in_array($cartItem, array_keys($this->eligibleProducts))) {
                return true;
            }
        }
        return false;
    }

    public function calculateDiscount(): array
    {
        $discounts = [];
        foreach ($this->cart->cartItems as $cartItem => $quantity) {
            if (in_array($cartItem, array_keys($this->eligibleProducts))) {
                $discount = 0;
                if ($this->eligibleProducts[$cartItem] <= 1) {
                    $discount += $quantity * app()->productsService->productsToArray()[$cartItem] * $this->eligibleProducts[$cartItem];
                } else {
                    $discount = app()->converter->convert($this->eligibleProducts[$cartItem], $this->cart->getCurrency());
                }
                $discountDetails = [
                    'discount' => ($discount),
                    'description' => $this->eligibleProducts[$cartItem] * 100 . '% off ' . $cartItem . ':'
                ];
                $discounts[] = $discountDetails;
            }
        }
        return $discounts;
    }
}
