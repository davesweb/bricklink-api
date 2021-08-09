<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\PriceGuide;

class PriceGuideTransformer extends BaseTransformer
{
    public static string $dto = PriceGuide::class;

    protected static array $toObject = [];
}
