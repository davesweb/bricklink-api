<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

use DateTime;

class Shipping
{
    public function __construct(
        public ?string $method = null,
        public ?string $methodId = null,
        public ?string $trackingNr = null,
        public ?string $trackingLink = null,
        public ?DateTime $dateShipped = null,
        public ?Address $address = null,
    ) {
    }
}
