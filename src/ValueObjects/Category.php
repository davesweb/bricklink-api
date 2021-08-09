<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class Category
{
    public function __construct(
        public ?int $categoryId = null,
        public ?string $categoryName = null,
        public ?int $parentId = null,
    ) {
    }
}
