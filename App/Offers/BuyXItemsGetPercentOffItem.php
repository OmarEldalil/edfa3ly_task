<?php


namespace App\Offers;


use App\Models\Cart;

class BuyXItemsGetPercentOffItem implements OfferInterface
{
    private Cart $cart;

    private string $boughtItem = 'T-Shirt';
    private int $x = 2;
    private float $discountPercentage = 0.5;
    private string $offItem = 'Jacket';

    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    public function isEligible(): bool
    {
        if (
            isset($this->cart->cartItems[$this->boughtItem]) &&
            $this->cart->cartItems[$this->boughtItem] >= $this->x &&
            isset($this->cart->cartItems[$this->offItem])
        ) {
            return true;
        }
        return false;
    }

    public function calculateDiscount(): array
    {
        $numberOfOffItemsToHaveDiscount = floor($this->cart->cartItems[$this->boughtItem] / $this->x);
        $numberOfOffItems = $this->cart->cartItems[$this->offItem];
        $totalDiscount = 0;
        while ($numberOfOffItemsToHaveDiscount > 0 && $numberOfOffItems > 0) {
            $numberOfOffItemsToHaveDiscount--;
            $numberOfOffItems--;

            $totalDiscount += $this->discountPercentage * app()->productsService->productsToArray()[$this->offItem];
        }
        return [
            'discount' => ($totalDiscount),
            'description' => $this->discountPercentage * 100 . '% Off ' . $this->offItem . ': '
        ];
    }
}
