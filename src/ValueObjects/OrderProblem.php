<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class OrderProblem
{
    public function __construct(
        public ?string $type = null,
        public ?string $message = null,
        public ?string $reasonId = null,
    ) {
    }
}
