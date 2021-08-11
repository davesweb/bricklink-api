<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\OrderItem;

class OrderItemTransformer extends BaseTransformer
{
    public static string $dto = OrderItem::class;

    protected static array $mapping = [
        'item' => ['item', ItemTransformer::class],
    ];
}
