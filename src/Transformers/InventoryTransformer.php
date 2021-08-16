<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Inventory;

class InventoryTransformer extends BaseTransformer
{
    public string $dto = Inventory::class;

    protected array $mapping = [
        'item'         => ['item', ItemTransformer::class],
        'date_created' => ['dateCreated', 'datetime'],
    ];
}
