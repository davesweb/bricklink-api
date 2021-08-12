<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Address;

class AddressTransformer extends BaseTransformer
{
    public string $dto = Address::class;

    protected array $mapping = [
        'name' => ['name', NameTransformer::class],
    ];
}
