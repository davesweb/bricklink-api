<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Address;

class AddressTransformer extends BaseTransformer
{
    public static string $dto = Address::class;

    protected static array $mapping = [
        'name' => ['name', NameTransformer::class],
    ];
}
