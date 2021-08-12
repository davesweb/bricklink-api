<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\OrderItem;

class OrderItemTransformer extends BaseTransformer
{
    public string $dto = OrderItem::class;

    protected array $mapping = [
        'item' => ['item', ItemTransformer::class],
    ];
}
