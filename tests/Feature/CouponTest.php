<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use DateTime;
use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\ValueObjects\Coupon;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\ValueObjects\AppliesTo;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Repositories\CouponRepository;
use Davesweb\BrinklinkApi\Transformers\CouponTransformer;

/**
 * @internal
 * @coversNothing
 */
class CouponTest extends TestCase
{
    public function testItReturnsIterableIndex(): void
    {
        $data       = $this->getDataArray('coupon');
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway, new CouponTransformer());

        $results = $repository->index();

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(Coupon::class, $results[0]);
        $this->assertCouponContent($data, $results[0]);
    }

    public function testItReturnsNullWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway, new CouponTransformer());

        $result = $repository->find(404);

        $this->assertNull($result);
    }

    public function testItThrowsWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway, new CouponTransformer());

        $this->expectException(NotFoundException::class);

        $repository->findOrFail(404);
    }

    public function testItReturnsACoupon(): void
    {
        $data       = $this->getDataArray('coupon');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway, new CouponTransformer());

        $result = $repository->find(1234);

        $this->assertInstanceOf(Coupon::class, $result);
        $this->assertCouponContent($data, $result);
    }

    public function testItStoresACoupon(): void
    {
        $data       = $this->getDataArray('coupon');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway, new CouponTransformer());

        $result = $repository->store(new Coupon(couponId: 12345));

        $this->assertInstanceOf(Coupon::class, $result);
        $this->assertCouponContent($data, $result);
    }

    public function testItUpdatesACoupon(): void
    {
        $data       = $this->getDataArray('coupon');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway, new CouponTransformer());

        $result = $repository->update(new Coupon(couponId: 12345));

        $this->assertInstanceOf(Coupon::class, $result);
        $this->assertCouponContent($data, $result);
    }

    public function testItDeletesACoupon(): void
    {
        $response   = BricklinkResponse::test(200, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CouponRepository($gateway, new CouponTransformer());

        $result = $repository->delete(new Coupon(couponId: 12345));

        $this->assertTrue($result);
    }

    protected function assertCouponContent(array $expected, Coupon $coupon): void
    {
        $this->assertEquals($expected['coupon_id'], $coupon->couponId);
        $this->assertInstanceOf(DateTime::class, $coupon->dateIssued);
        $this->assertInstanceOf(DateTime::class, $coupon->dateExpire);
        $this->assertEquals($expected['seller_name'], $coupon->sellerName);
        $this->assertEquals($expected['buyer_name'], $coupon->buyerName);
        $this->assertEquals($expected['store_name'], $coupon->storeName);
        $this->assertEquals($expected['status'], $coupon->status);
        $this->assertEquals($expected['remarks'], $coupon->remarks);
        $this->assertEquals($expected['order_id'], $coupon->orderId);
        $this->assertEquals($expected['currency_code'], $coupon->currencyCode);
        $this->assertEquals($expected['disp_currency_code'], $coupon->dispCurrencyCode);
        $this->assertInstanceOf(AppliesTo::class, $coupon->appliesTo);
        $this->assertEquals($expected['applies_to']['type'], $coupon->appliesTo->type);
        $this->assertEquals($expected['applies_to']['item_type'], $coupon->appliesTo->itemType);
        $this->assertEquals($expected['applies_to']['except_on_sale'], $coupon->appliesTo->exceptOnSale);
        $this->assertEquals($expected['discount_amount'], $coupon->discountAmount);
        $this->assertEquals($expected['disp_discount_amount'], $coupon->dispDiscountAmount);
        $this->assertEquals($expected['discount_rate'], $coupon->discountRate);
        $this->assertEquals($expected['max_discount_amount'], $coupon->maxDiscountAmount);
        $this->assertEquals($expected['disp_max_discount_amount'], $coupon->dispMaxDiscountAmount);
        $this->assertEquals($expected['tier_price1'], $coupon->tierPrice1);
        $this->assertEquals($expected['disp_tier_price1'], $coupon->dispTierPrice1);
        $this->assertEquals($expected['tier_discount_rate1'], $coupon->tierDiscountRate1);
        $this->assertEquals($expected['tier_price2'], $coupon->tierPrice2);
        $this->assertEquals($expected['disp_tier_price2'], $coupon->dispTierPrice2);
        $this->assertEquals($expected['tier_discount_rate2'], $coupon->tierDiscountRate2);
        $this->assertEquals($expected['tier_price3'], $coupon->tierPrice3);
        $this->assertEquals($expected['disp_tier_price3'], $coupon->dispTierPrice3);
        $this->assertEquals($expected['tier_discount_rate3'], $coupon->tierDiscountRate3);
    }
}
