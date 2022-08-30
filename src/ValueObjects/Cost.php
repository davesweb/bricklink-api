<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class Cost
{
    public function __construct(
        public ?string $currencyCode = null,
        public ?float $subtotal = null,
        public ?float $grandTotal = null,
        public ?float $finalTotal = null,
        public ?float $salestaxCollectedByBl = null,
        public ?float $etc1 = null,
        public ?float $etc2 = null,
        public ?float $insurance = null,
        public ?float $shipping = null,
        public ?float $credit = null,
        public ?float $coupon = null,
        public ?float $vatRate = null,
        public ?float $vatAmount = null,
    ) {
    }
}
