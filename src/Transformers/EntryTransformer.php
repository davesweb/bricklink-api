<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Entry;

class EntryTransformer extends BaseTransformer
{
    public static string $dto = Entry::class;

    protected static array $toObject = [];
}
