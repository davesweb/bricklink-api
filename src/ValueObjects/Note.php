<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

use DateTime;

class Note
{
    public function __construct(
        public ?int $noteId = null,
        public ?string $username = null,
        public ?string $text = null,
        public ?DateTime $dateNoted = null,
    ) {
    }
}
