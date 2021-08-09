<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Order;

class OrderTransformer extends BaseTransformer
{
    public static string $dto = Order::class;

    protected static array $toObject = [];
}
