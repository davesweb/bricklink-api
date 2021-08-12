<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Subset;

class SubsetTransformer extends BaseTransformer
{
    public string $dto = Subset::class;

    protected array $mapping = [
        'entries' => ['entries', 'array', EntryTransformer::class],
    ];
}
