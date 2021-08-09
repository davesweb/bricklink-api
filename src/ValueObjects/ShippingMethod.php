<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class ShippingMethod
{
    public function __construct(
        public ?int $methodId = null,
        public ?string $name = null,
        public ?string $note = null,
        public ?bool $insurance = null,
        public ?bool $isDefault = null,
        public ?string $area = null,
        public ?bool $isAvailable = null,
    ) {
    }
}
