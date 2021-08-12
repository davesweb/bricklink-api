<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\PriceDetail;

class PriceDetailTransformer extends BaseTransformer
{
    public string $dto = PriceDetail::class;

    protected array $mapping = [
        'date_ordered' => ['dateOrdered', 'datetime'],
    ];
}
