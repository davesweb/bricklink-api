<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class Mapping
{
    public function __construct(
        public ?Item $item = null,
        public ?int $colorId = null,
        public ?string $colorName = null,
        public ?string $elementId = null,
    ) {
    }
}
