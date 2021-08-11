<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Item;

class ItemTransformer extends BaseTransformer
{
    public static string $dto = Item::class;

    protected static array $mapping = [
        'no' => 'number',
    ];
}
