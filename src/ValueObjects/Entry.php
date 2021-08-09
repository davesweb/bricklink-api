<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class Entry
{
    public function __construct(
        public ?Item $item = null,
        public ?int $quantity = null,
        public ?string $appearAs = null,
        public ?int $colorId = null,
        public ?int $extraQuantity = null,
        public ?bool $isAlternate = null,
        public ?bool $isCounterpart = null,
    ) {
    }
}
