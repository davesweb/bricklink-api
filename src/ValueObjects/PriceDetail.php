<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

use DateTime;

class PriceDetail
{
    public function __construct(
        public ?int $quantity = null,
        public ?float $unitPrice = null,
        public ?bool $shippingAvailable = null,
        public ?string $sellerCountryCode = null,
        public ?string $buyerCountryCode = null,
        public ?DateTime $dateOrdered = null,
    ) {
    }
}
