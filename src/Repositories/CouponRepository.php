<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Coupon;
use Davesweb\BrinklinkApi\Transformers\CouponTransformer;

class CouponRepository extends BaseRepository
{
    public const DIRECTION_IN  = 'in';
    public const DIRECTION_OUT = 'out';

    public function index(string $direction = self::DIRECTION_OUT, string|array|null $statuses = null): iterable
    {
        $uri = $this->uri('coupons', [], [
            'direction' => $direction,
            'status'    => $this->toParam($statuses),
        ]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = CouponTransformer::toObject($data);
        }

        return $values;
    }

    public function find(int $id): ?Coupon
    {
        $response = $this->gateway->get($this->uri('/coupons/{id}', ['id' => $id]));

        if (!$response->hasData()) {
            return null;
        }

        /** @var Coupon $coupon */
        $coupon = CouponTransformer::toObject($response->getData());

        return $coupon;
    }

    public function store(Coupon $coupon): Coupon
    {
        $response = $this->gateway->post('coupons', CouponTransformer::toArray($coupon));

        /** @var Coupon $newCoupon */
        $newCoupon = CouponTransformer::toObject($response->getData());

        return $newCoupon;
    }

    public function update(Coupon $coupon): Coupon
    {
        $response = $this->gateway->put($this->uri('coupons/{id}', ['id' => $coupon->couponId]), CouponTransformer::toArray($coupon));

        /** @var Coupon $newCoupon */
        $newCoupon = CouponTransformer::toObject($response->getData());

        return $newCoupon;
    }

    public function delete(Coupon $coupon): bool
    {
        $response = $this->gateway->delete($this->uri('coupons/{id}', ['id' => $coupon->couponId]));

        return $response->isSuccessful();
    }
}
