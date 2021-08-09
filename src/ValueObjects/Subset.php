<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class Subset
{
    public function __construct(
        public ?int $matchNumber = null,
        public ?iterable $entries = null,
    ) {
    }
}
