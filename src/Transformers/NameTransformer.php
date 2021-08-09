<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Name;

class NameTransformer extends BaseTransformer
{
    protected static string $dto = Name::class;

    protected static array $toObject = [
        'full'  => 'full',
        'first' => 'first',
        'last'  => 'last',
    ];
}
