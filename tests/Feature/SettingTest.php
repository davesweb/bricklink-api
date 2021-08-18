<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\ValueObjects\ShippingMethod;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Repositories\SettingRepository;
use Davesweb\BrinklinkApi\Transformers\ShippingMethodTransformer;

/**
 * @internal
 * @coversNothing
 */
class SettingTest extends TestCase
{
    public function testItReturnsShippingMethods(): void
    {
        $data       = $this->getDataArray('shipping_method');
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new SettingRepository($gateway, new ShippingMethodTransformer());

        $results = $repository->shippingMethods();

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(ShippingMethod::class, $results[0]);
        $this->assertShippingMethodContent($data, $results[0]);
    }

    public function testItReturnsNullWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new SettingRepository($gateway, new ShippingMethodTransformer());

        $result = $repository->findShippingMethod(404);

        $this->assertNull($result);
    }

    public function testItThrowsWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new SettingRepository($gateway, new ShippingMethodTransformer());

        $this->expectException(NotFoundException::class);

        $repository->findOrFailShippingMethod(404);
    }

    public function testItReturnsAShippingMethod(): void
    {
        $data       = $this->getDataArray('shipping_method');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new SettingRepository($gateway, new ShippingMethodTransformer());

        $result = $repository->findShippingMethod(1234);

        $this->assertInstanceOf(ShippingMethod::class, $result);
        $this->assertShippingMethodContent($data, $result);
    }

    protected function assertShippingMethodContent(array $expected, ShippingMethod $shippingMethod): void
    {
        $this->assertEquals($expected['method_id'], $shippingMethod->methodId);
        $this->assertEquals($expected['name'], $shippingMethod->name);
        $this->assertEquals($expected['note'], $shippingMethod->note);
        $this->assertEquals($expected['insurance'], $shippingMethod->insurance);
        $this->assertEquals($expected['is_default'], $shippingMethod->isDefault);
        $this->assertEquals($expected['area'], $shippingMethod->area);
        $this->assertEquals($expected['is_available'], $shippingMethod->isAvailable);
    }
}
