<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Inventory;

class InventoryTransformer extends BaseTransformer
{
    public static string $dto = Inventory::class;

    protected static array $mapping = [
        'item'         => ['item', ItemTransformer::class],
        'date_created' => ['date_created', 'datetime'],
    ];
}
