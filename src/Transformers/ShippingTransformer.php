<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Shipping;

class ShippingTransformer extends BaseTransformer
{
    public string $dto = Shipping::class;

    protected array $mapping = [
        'date_shipped' => ['dateShipped', 'datetime'],
        'address'      => ['address', AddressTransformer::class],
    ];
}
