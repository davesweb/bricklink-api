<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Superset;

class SupersetTransformer extends BaseTransformer
{
    public string $dto = Superset::class;

    protected array $mapping = [
        'entries' => ['entries', 'array', EntryTransformer::class],
    ];
}
