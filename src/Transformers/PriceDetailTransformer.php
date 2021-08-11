<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\PriceDetail;

class PriceDetailTransformer extends BaseTransformer
{
    public static string $dto = PriceDetail::class;

    protected static array $mapping = [
        'date_ordered' => ['dateOrdered', 'datetime'],
    ];
}
