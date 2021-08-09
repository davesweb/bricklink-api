<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class Rating
{
    public function __construct(
        public ?string $username = null,
        public ?iterable $rating = null,
    ) {
    }
}
