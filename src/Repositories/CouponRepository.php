<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use Davesweb\BrinklinkApi\ValueObjects\Coupon;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Transformers\CouponTransformer;

class CouponRepository extends BaseRepository
{
    public const DIRECTION_IN  = 'in';
    public const DIRECTION_OUT = 'out';

    public function __construct(BricklinkGateway $gateway, CouponTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function index(string $direction = self::DIRECTION_OUT, string|array|null $statuses = null): iterable
    {
        $uri = uri('coupons', [], [
            'direction' => $direction,
            'status'    => $this->toParam($statuses),
        ]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->transformer->toObject($data);
        }

        return $values;
    }

    public function find(int $id): ?Coupon
    {
        $response = $this->gateway->get(uri('/coupons/{id}', ['id' => $id]));

        if (!$response->hasData()) {
            return null;
        }

        /** @var Coupon $coupon */
        $coupon = $this->transformer->toObject($response->getData());

        return $coupon;
    }

    public function store(Coupon $coupon): Coupon
    {
        $response = $this->gateway->post('coupons', $this->transformer->toArray($coupon));

        /** @var Coupon $newCoupon */
        $newCoupon = $this->transformer->toObject($response->getData());

        return $newCoupon;
    }

    public function update(Coupon $coupon): Coupon
    {
        $response = $this->gateway->put(uri('coupons/{id}', ['id' => $coupon->couponId]), $this->transformer->toArray($coupon));

        /** @var Coupon $newCoupon */
        $newCoupon = $this->transformer->toObject($response->getData());

        return $newCoupon;
    }

    public function delete(Coupon $coupon): bool
    {
        $response = $this->gateway->delete(uri('coupons/{id}', ['id' => $coupon->couponId]));

        return $response->isSuccessful();
    }
}
