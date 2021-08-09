<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

use DateTime;

class Payment
{
    public function __construct(
        public ?string $method = null,
        public ?string $currencyCode = null,
        public ?DateTime $datePaid = null,
        public ?string $status = null,
    ) {
    }
}
