<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Cost;

class CostTransformer extends BaseTransformer
{
    public static string $dto = Cost::class;

    protected static array $toObject = [];
}
