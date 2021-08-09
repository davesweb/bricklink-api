<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

class Address
{
    public function __construct(
        public ?Name $name = null,
        public ?string $full = null,
        public ?string $address1 = null,
        public ?string $address2 = null,
        public ?string $countryCode = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $postalCode = null,
    ) {
    }
}
