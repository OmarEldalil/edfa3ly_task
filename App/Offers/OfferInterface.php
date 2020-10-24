<?php

namespace App\Offers;
interface OfferInterface
{
    public function isEligible(): bool;

    public function calculateDiscount(): array;
}
