<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class Item
{
    public function __construct(
        public ?string $number = null,
        public ?string $name = null,
        public ?string $type = null,
        public ?int $categoryId = null,
        public ?string $alternateNo = null,
        public ?string $imageUrl = null,
        public ?string $thumbnailUrl = null,
        public ?float $weight = null,
        public ?float $dimX = null,
        public ?float $dimY = null,
        public ?float $dimZ = null,
        public ?int $yearReleased = null,
        public ?string $description = null,
        public ?bool $isObsolete = null,
        public ?string $languageCode = null,
    ) {
    }
}
