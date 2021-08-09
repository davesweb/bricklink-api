<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class Color
{
    public function __construct(
        public ?int $colorId = null,
        public ?string $colorName = null,
        public ?string $colorCode = null,
        public ?string $colorType = null,
    ) {
    }
}
