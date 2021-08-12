<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\ShippingMethod;

class ShippingMethodTransformer extends BaseTransformer
{
    public string $dto = ShippingMethod::class;
}
