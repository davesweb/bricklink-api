<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class Superset
{
    public function __construct(
        public ?int $colorId = null,
        public ?iterable $entries = null,
    ) {
    }
}
