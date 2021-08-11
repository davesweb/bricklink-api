<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Shipping;

class ShippingTransformer extends BaseTransformer
{
    public static string $dto = Shipping::class;

    protected static array $mapping = [
        'date_shipped' => ['dateShipped', 'datetime'],
        'address'      => ['address', AddressTransformer::class],
    ];
}
