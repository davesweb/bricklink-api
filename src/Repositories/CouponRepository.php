<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Coupon;

class CouponRepository extends BaseRepository
{
    public const DIRECTION_IN  = 'in';
    public const DIRECTION_OUT = 'out';

    public function index(string $direction = self::DIRECTION_OUT, string|array|null $statuses = null): iterable
    {
    }

    public function find(int $id): ?Coupon
    {
    }

    public function store(Coupon $coupon): Coupon
    {
    }

    public function update(Coupon $coupon): Coupon
    {
    }

    public function delete(Coupon $coupon): bool
    {
    }
}
