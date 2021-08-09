<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class OrderItem
{
    public function __construct(
        public ?string $inventoryId = null,
        public ?Item $item = null,
        public ?int $colorId = null,
        public ?string $colorName = null,
        public ?int $quantity = null,
        public ?string $newOrUsed = null,
        public ?string $completeness = null,
        public ?float $unitPrice = null,
        public ?float $unitPriceFinal = null,
        public ?float $dispUnitPrice = null,
        public ?float $dispUnitPriceFinal = null,
        public ?string $currencyCode = null,
        public ?string $dispCurrencyCode = null,
        public ?string $remarks = null,
        public ?string $description = null,
        public ?float $weight = null,
    ) {
    }
}
