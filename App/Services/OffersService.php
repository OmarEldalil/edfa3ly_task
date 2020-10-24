<?php


namespace App\Services;


use App\Offers\OfferInterface;

class OffersService
{

    private array $availableOffers;

    public function __construct()
    {
        $this->availableOffers = isset(app()->config['available_offers']) ? app()->config['available_offers'] : [];
    }

    public function applyAvailableOffers($cart)
    {
        $discounts = [];
        foreach ($this->availableOffers as $availableOffer) {
            /**
             * @var OfferInterface $offer
             */
            $offer = new $availableOffer($cart);
            if (!$offer instanceof OfferInterface) {
                throw new \Exception('Offer must implement the offer interface');
            }
            if ($offer->isEligible()) {
                $offerDiscounts = $offer->calculateDiscount();
                if (isset($offerDiscounts[0])) {
                    foreach ($offerDiscounts as $discount){
                        $discounts[] = $discount;
                    }
                } else {
                    $discounts[] = $offerDiscounts;
                }
            }
        }
        return $discounts;
    }

}
