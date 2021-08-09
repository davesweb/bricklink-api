<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Superset;

class SupersetTransformer extends BaseTransformer
{
    public static string $dto = Superset::class;

    protected static array $toObject = [];
}
