<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

use DateTime;

class Coupon
{
    public function __construct(
        public ?int $couponId = null,
        public ?DateTime $dateIssued = null,
        public ?DateTime $dateExpire = null,
        public ?string $sellerName = null,
        public ?string $buyerName = null,
        public ?string $storeName = null,
        public ?string $status = null,
        public ?string $remarks = null,
        public ?int $orderId = null,
        public ?string $currencyCode = null,
        public ?string $dispCurrencyCode = null,
        public ?string $discountType = null,
        public ?AppliesTo $appliesTo = null,
        public ?float $discountAmount = null,
        public ?float $dispDiscountAmount = null,
        public ?int $discountRate = null,
        public ?float $maxDiscountAmount = null,
        public ?float $dispMaxDiscountAmount = null,
        public ?float $tierPrice1 = null,
        public ?float $dispTierPrice1 = null,
        public ?int $tierDiscountRate1 = null,
        public ?float $tierPrice2 = null,
        public ?float $dispTierPrice2 = null,
        public ?int $tierDiscountRate2 = null,
        public ?float $tierPrice3 = null,
        public ?float $dispTierPrice3 = null,
        public ?int $tierDiscountRate3 = null,
    ) {
    }
}
