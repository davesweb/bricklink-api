<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\ShippingMethod;

class ShippingMethodTransformer extends BaseTransformer
{
    public static string $dto = ShippingMethod::class;

    protected static array $toObject = [];
}
