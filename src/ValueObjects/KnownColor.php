<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class KnownColor
{
    public function __construct(
        public ?int $colorId = null,
        public ?int $quantity = null,
    ) {
    }
}
