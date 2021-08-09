<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

use DateTime;

class Notification
{
    public function __construct(
        public ?string $eventType = null,
        public ?int $resourceId = null,
        public ?DateTime $timestamp = null,
    ) {
    }
}
