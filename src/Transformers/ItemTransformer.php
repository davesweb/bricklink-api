<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Item;

class ItemTransformer extends BaseTransformer
{
    public string $dto = Item::class;

    protected array $mapping = [
        'no' => 'number',
    ];
}
