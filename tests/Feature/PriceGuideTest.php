<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\ValueObjects\Item;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\ValueObjects\PriceGuide;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Repositories\PriceGuideRepository;
use Davesweb\BrinklinkApi\Transformers\PriceGuideTransformer;

/**
 * @internal
 * @coversNothing
 */
class PriceGuideTest extends TestCase
{
    public function testItReturnsNullWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new PriceGuideRepository($gateway, new PriceGuideTransformer());

        $result = $repository->find(404);

        $this->assertNull($result);
    }

    public function testItThrowsWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new PriceGuideRepository($gateway, new PriceGuideTransformer());

        $this->expectException(NotFoundException::class);

        $repository->findOrFail(404);
    }

    public function testItReturnsAnInventory(): void
    {
        $data       = $this->getDataArray('price_guide');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new PriceGuideRepository($gateway, new PriceGuideTransformer());

        $result = $repository->find(1234);

        $this->assertInstanceOf(PriceGuide::class, $result);
        $this->assertPriceGuideContent($data, $result);
    }

    protected function assertPriceGuideContent(array $expected, PriceGuide $priceGuide): void
    {
        $this->assertInstanceOf(Item::class, $priceGuide->item);
        $this->assertEquals($expected['item']['no'], $priceGuide->item->number);
        $this->assertEquals($expected['item']['type'], $priceGuide->item->type);
        $this->assertEquals($expected['new_or_used'], $priceGuide->newOrUsed);
        $this->assertEquals($expected['currency_code'], $priceGuide->currencyCode);
        $this->assertEquals($expected['min_price'], $priceGuide->minPrice);
        $this->assertEquals($expected['max_price'], $priceGuide->maxPrice);
        $this->assertEquals($expected['avg_price'], $priceGuide->avgPrice);
        $this->assertEquals($expected['qty_avg_price'], $priceGuide->qtyAvgPrice);
        $this->assertEquals($expected['unit_quantity'], $priceGuide->unitQuantity);
        $this->assertIsArray($priceGuide->priceDetail);
        $this->assertGreaterThan(0, count($priceGuide->priceDetail));
        $this->assertEquals($expected['price_detail'][0]['quantity'], $priceGuide->priceDetail[0]->quantity);
        $this->assertEquals($expected['price_detail'][0]['qunatity'], $priceGuide->priceDetail[0]->qunatity);
        $this->assertEquals($expected['price_detail'][0]['unit_price'], $priceGuide->priceDetail[0]->unitPrice);
        $this->assertEquals($expected['price_detail'][0]['shipping_available'], $priceGuide->priceDetail[0]->shippingAvailable);
    }
}
