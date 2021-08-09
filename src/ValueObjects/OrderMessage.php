<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

use DateTime;

class OrderMessage
{
    public function __construct(
        public ?string $subject = null,
        public ?string $body = null,
        public ?string $from = null,
        public ?string $to = null,
        public ?DateTime $dateSent = null,
    ) {
    }
}
