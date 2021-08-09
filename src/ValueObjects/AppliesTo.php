<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class AppliesTo
{
    public function __construct(
        public ?string $type = null,
        public ?string $itemType = null,
        public ?bool $exceptOnSale = null,
    ) {
    }
}
