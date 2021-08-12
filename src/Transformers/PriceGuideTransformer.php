<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\PriceGuide;

class PriceGuideTransformer extends BaseTransformer
{
    public string $dto = PriceGuide::class;

    protected array $mapping = [
        'item'         => ['item', ItemTransformer::class],
        'price_detail' => ['priceDetail', 'array', PriceDetailTransformer::class],
    ];
}
