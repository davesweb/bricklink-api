<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class Item
{
    public function __construct(
        public ?string $no = null,
        public ?string $name = null,
        public ?string $type = null,
        public ?int $categoryId = null,
    ) {
    }
}
