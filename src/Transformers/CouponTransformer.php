<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Coupon;

class CouponTransformer extends BaseTransformer
{
    public static string $dto = Coupon::class;

    protected static array $mapping = [
        'date_issued' => ['dateIssued', 'datetime'],
        'date_expire' => ['dateExpire', 'datetime'],
        'applies_to'  => ['appliesTo', AppliesToTransformer::class],
    ];
}
