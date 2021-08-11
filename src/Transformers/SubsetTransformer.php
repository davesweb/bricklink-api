<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Subset;

class SubsetTransformer extends BaseTransformer
{
    public static string $dto = Subset::class;

    protected static array $mapping = [
        'entries' => ['entries', 'array', EntryTransformer::class],
    ];
}
