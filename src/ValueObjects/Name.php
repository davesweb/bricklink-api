<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class Name
{
    public function __construct(
        public ?string $full = null,
        public ?string $first = null,
        public ?string $last = null,
    ) {
    }
}
