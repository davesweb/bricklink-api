<?php

namespace Davesweb\BrinklinkApi\Tests\Feature\Repositories;

use Davesweb\BrinklinkApi\Transformers\CouponTransformer;
use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\ValueObjects\Coupon;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\Repositories\CouponRepository;

/**
 * @internal
 * @coversNothing
 */
class CouponRepositoryTest extends TestCase
{
    public function testItReturnsIterableIndex(): void
    {
        $response   = BricklinkResponse::test(200, [json_decode(file_get_contents(__DIR__.'/../../responses/coupon.json'), true)]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway);

        $results = $repository->index();

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(Coupon::class, $results[0]);
    }

    public function testItReturnsNullWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway);

        $result = $repository->find(404);

        $this->assertNull($result);
    }

    public function testItReturnsACoupon(): void
    {
        $response   = BricklinkResponse::test(200, json_decode(file_get_contents(__DIR__.'/../../responses/coupon.json'), true));
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway);

        $result = $repository->find(1234);

        $this->assertInstanceOf(Coupon::class, $result);
    }

    public function testItStoresACoupon(): void
    {
        $response   = BricklinkResponse::test(200, json_decode(file_get_contents(__DIR__.'/../../responses/coupon.json'), true));
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway);

        $result = $repository->store(new Coupon(couponId: 12345));

        $this->assertInstanceOf(Coupon::class, $result);
    }

    public function testItUpdatesACoupon(): void
    {
        $response   = BricklinkResponse::test(200, json_decode(file_get_contents(__DIR__.'/../../responses/coupon.json'), true));
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway);

        $result = $repository->update(new Coupon(couponId: 12345));

        $this->assertInstanceOf(Coupon::class, $result);
    }

    public function testItDeletesACoupon(): void
    {
        $response   = BricklinkResponse::test(200, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway);

        $result = $repository->delete(new Coupon(couponId: 12345));

        $this->assertTrue($result);
    }
}
