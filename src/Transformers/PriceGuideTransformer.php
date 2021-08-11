<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\PriceGuide;

class PriceGuideTransformer extends BaseTransformer
{
    public static string $dto = PriceGuide::class;

    protected static array $mapping = [
        'item'         => ['item', ItemTransformer::class],
        'price_detail' => ['priceDetail', 'array', PriceDetailTransformer::class],
    ];
}
