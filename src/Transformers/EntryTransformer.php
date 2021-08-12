<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Entry;

class EntryTransformer extends BaseTransformer
{
    public string $dto = Entry::class;

    protected array $mapping = [
        'item' => ['item', ItemTransformer::class],
    ];
}
