<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

use DateTime;

class Feedback
{
    public function __construct(
        public ?int $feedbackId = null,
        public ?int $orderId = null,
        public ?string $from = null,
        public ?string $to = null,
        public ?DateTime $dateRated = null,
        public ?int $rating = null,
        public ?string $ratingOfBs = null,
        public ?string $comment = null,
        public ?string $reply = null,
    ) {
    }
}
