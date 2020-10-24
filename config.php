<?php
return [
    'tax' => 0.14,
    'default_currency' => 'USD',
    'available_offers' => [
        \App\Offers\ProductDiscount::class,
        \App\Offers\BuyXItemsGetPercentOffItem::class
    ]
];
