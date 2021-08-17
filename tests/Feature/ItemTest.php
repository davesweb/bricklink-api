<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\ValueObjects\Item;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\Repositories\ItemRepository;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Transformers\ItemTransformer;
use Davesweb\BrinklinkApi\Transformers\KnownColorTransformer;

/**
 * @internal
 * @coversNothing
 */
class ItemTest extends TestCase
{
    public function testItReturnsNullWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ItemRepository($gateway, new ItemTransformer(), new KnownColorTransformer());

        $result = $repository->find(404);

        $this->assertNull($result);
    }

    public function testItThrowsWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ItemRepository($gateway, new ItemTransformer(), new KnownColorTransformer());

        $this->expectException(NotFoundException::class);

        $repository->findOrFail(404);
    }

    public function testItReturnsAnItem(): void
    {
        $data       = $this->getDataArray('item');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ItemRepository($gateway, new ItemTransformer(), new KnownColorTransformer());

        $result = $repository->find(1234);

        $this->assertInstanceOf(Item::class, $result);
        $this->assertItemContent($data, $result);
    }

    public function testItReturnsNullWhenNoImageFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ItemRepository($gateway, new ItemTransformer(), new KnownColorTransformer());

        $result = $repository->findItemImage(new Item(404));

        $this->assertNull($result);
    }

    public function testItThrowsWhenNoImageFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ItemRepository($gateway, new ItemTransformer(), new KnownColorTransformer());

        $this->expectException(NotFoundException::class);

        $repository->findOrFailItemImage(new Item(404));
    }

    public function testItReturnsAnItemImage(): void
    {
        $data       = $this->getDataArray('item');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ItemRepository($gateway, new ItemTransformer(), new KnownColorTransformer());

        $result = $repository->findItemImage(new Item(1234));

        $this->assertInstanceOf(Item::class, $result);
        $this->assertItemContent($data, $result);
    }

    protected function assertItemContent(array $expected, Item $item): void
    {
        $this->assertEquals($expected['no'], $item->number);
        $this->assertEquals($expected['name'], $item->name);
        $this->assertEquals($expected['type'], $item->type);
        $this->assertEquals($expected['image_url'], $item->imageUrl);
        $this->assertEquals($expected['thumbnail_url'], $item->thumbnailUrl);
        $this->assertEquals($expected['weight'], $item->weight);
        $this->assertEquals($expected['dim_x'], $item->dimX);
        $this->assertEquals($expected['dim_y'], $item->dimY);
        $this->assertEquals($expected['dim_z'], $item->dimZ);
        $this->assertEquals($expected['year_released'], $item->yearReleased);
        $this->assertEquals($expected['is_obsolete'], $item->isObsolete);
        $this->assertEquals($expected['category_id'], $item->categoryId);
    }
}
