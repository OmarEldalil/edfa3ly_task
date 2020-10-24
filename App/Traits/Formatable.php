<?php

namespace App\Traits;

trait Formatable
{
    public function displayTotalDetails()
    {
        $this->displaySubTotal();
        $this->displayTax();
        $this->displayDiscounts();
        $this->displayTotal();
    }

    public function displaySubTotal()
    {
        echo "Subtotal: " . $this->getSubTotal() . " $this->currency \r\n";
    }

    public function displayTax()
    {
        echo "Taxes: " . $this->getTax() . " $this->currency \r\n";
    }

    public function displayDiscounts()
    {
        if (count($this->discounts)) {
            echo "Discounts: \r\n";
            foreach ($this->discounts as $discount) {
                echo "\t " . $discount['description'] . ' ' . $discount['discount'] . ' ' . $this->currency . "\r\n";
            }
        }
    }

    public function displayTotal()
    {
        echo "Total: " . $this->getTotal() . " $this->currency \r\n";
    }
}
