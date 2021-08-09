<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class PriceGuide
{
    public function __construct(
        public ?Item $item = null,
        public ?string $newOrUsed = null,
        public ?string $currencyCode = null,
        public ?float $minPrice = null,
        public ?float $maxPrice = null,
        public ?float $avgPrice = null,
        public ?float $qtyAvgPrice = null,
        public ?int $unitQuantity = null,
        public ?int $totalQuantity = null,
        public ?iterable $priceDetail = null,
    ) {
    }
}
