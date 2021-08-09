<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Coupon;

class CouponTransformer extends BaseTransformer
{
    public static string $dto = Coupon::class;

    protected static array $toObject = [];
}
