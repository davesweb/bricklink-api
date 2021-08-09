<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\AppliesTo;

class AppliesToTransformer extends BaseTransformer
{
    public static string $dto = AppliesTo::class;

    protected static array $toObject = [];
}
