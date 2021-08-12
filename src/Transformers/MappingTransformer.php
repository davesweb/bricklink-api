<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Mapping;

class MappingTransformer extends BaseTransformer
{
    public string $dto = Mapping::class;

    protected array $mapping = [
        'item' => ['item', ItemTransformer::class],
    ];
}
