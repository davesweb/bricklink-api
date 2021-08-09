<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Inventory;

class InventoryTransformer extends BaseTransformer
{
    public static string $dto = Inventory::class;

    protected static array $toObject = [];
}
