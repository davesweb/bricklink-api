<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use DateTime;
use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\ValueObjects\Item;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\ValueObjects\Inventory;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Repositories\InventoryRepository;
use Davesweb\BrinklinkApi\Transformers\InventoryTransformer;

/**
 * @internal
 * @coversNothing
 */
class InventoryTest extends TestCase
{
    public function testItReturnsIterableIndex(): void
    {
        $data       = $this->getDataArray('inventory');
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new InventoryRepository($gateway, new InventoryTransformer());

        $results = $repository->index();

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(Inventory::class, $results[0]);
        $this->assertInventoryContent($data, $results[0]);
    }

    public function testItReturnsNullWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new InventoryRepository($gateway, new InventoryTransformer());

        $result = $repository->find(404);

        $this->assertNull($result);
    }

    public function testItThrowsWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new InventoryRepository($gateway, new InventoryTransformer());

        $this->expectException(NotFoundException::class);

        $repository->findOrFail(404);
    }

    public function testItReturnsAnInventory(): void
    {
        $data       = $this->getDataArray('inventory');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new InventoryRepository($gateway, new InventoryTransformer());

        $result = $repository->find(1234);

        $this->assertInstanceOf(Inventory::class, $result);
        $this->assertInventoryContent($data, $result);
    }

    public function testItStoresAnInventory(): void
    {
        $data       = $this->getDataArray('inventory');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new InventoryRepository($gateway, new InventoryTransformer());

        $result = $repository->store(new Inventory(inventoryId: 12345));

        $this->assertInstanceOf(Inventory::class, $result);
        $this->assertInventoryContent($data, $result);
    }

    public function testItUpdatesAnInventory(): void
    {
        $data       = $this->getDataArray('inventory');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new InventoryRepository($gateway, new InventoryTransformer());

        $result = $repository->update(new Inventory(inventoryId: 12345));

        $this->assertInstanceOf(Inventory::class, $result);
        $this->assertInventoryContent($data, $result);
    }

    public function testItDeletesAnInventory(): void
    {
        $response   = BricklinkResponse::test(200, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new InventoryRepository($gateway, new InventoryTransformer());

        $result = $repository->delete(new Inventory(inventoryId: 12345));

        $this->assertTrue($result);
    }

    protected function assertInventoryContent(array $expected, Inventory $inventory): void
    {
        $this->assertEquals($expected['inventory_id'], $inventory->inventoryId);
        $this->assertInstanceOf(Item::class, $inventory->item);
        $this->assertEquals($expected['item']['no'], $inventory->item->number);
        $this->assertEquals($expected['item']['name'], $inventory->item->name);
        $this->assertEquals($expected['item']['type'], $inventory->item->type);
        $this->assertEquals($expected['item']['categoryID'], $inventory->item->categoryId);
        $this->assertEquals($expected['color_id'], $inventory->colorId);
        $this->assertEquals($expected['quantity'], $inventory->quantity);
        $this->assertEquals($expected['new_or_used'], $inventory->newOrUsed);
        $this->assertEquals($expected['unit_price'], $inventory->unitPrice);
        $this->assertEquals($expected['bind_id'], $inventory->bindId);
        $this->assertEquals($expected['description'], $inventory->description);
        $this->assertEquals($expected['remarks'], $inventory->remarks);
        $this->assertEquals($expected['bulk'], $inventory->bulk);
        $this->assertEquals($expected['is_retain'], $inventory->isRetain);
        $this->assertEquals($expected['is_stock_room'], $inventory->isStockRoom);
        $this->assertInstanceOf(DateTime::class, $inventory->dateCreated);
        $this->assertEquals($expected['sale_rate'], $inventory->saleRate);
        $this->assertEquals($expected['my_cost'], $inventory->myCost);
        $this->assertEquals($expected['tier_quantity1'], $inventory->tierQuantity1);
        $this->assertEquals($expected['tier_price1'], $inventory->tierPrice1);
        $this->assertEquals($expected['tier_quantity2'], $inventory->tierQuantity2);
        $this->assertEquals($expected['tier_price2'], $inventory->tierPrice2);
        $this->assertEquals($expected['tier_quantity3'], $inventory->tierQuantity3);
        $this->assertEquals($expected['tier_price3'], $inventory->tierPrice3);
    }
}
