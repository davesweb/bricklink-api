<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\ValueObjects\Item;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\ValueObjects\Mapping;
use Davesweb\BrinklinkApi\Repositories\MappingRepository;
use Davesweb\BrinklinkApi\Transformers\MappingTransformer;

/**
 * @internal
 * @coversNothing
 */
class MappingTest extends TestCase
{
    public function testItReturnsNullWhenNoElementMappingIsFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new MappingRepository($gateway, new MappingTransformer());

        $result = $repository->getElementId('404');

        $this->assertNull($result);
    }

    public function testItReturnsAnElementId(): void
    {
        $data       = $this->getDataArray('mapping');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new MappingRepository($gateway, new MappingTransformer());

        $result = $repository->getElementId('3001');

        $this->assertInstanceOf(Mapping::class, $result);
        $this->assertMappingContent($data, $result);
    }

    public function testItReturnsNullWhenNoItemMappingIsFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new MappingRepository($gateway, new MappingTransformer());

        $result = $repository->getItemNumber('bel004c01');

        $this->assertNull($result);
    }

    public function testItReturnsAnItem(): void
    {
        $data       = $this->getDataArray('mapping');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new MappingRepository($gateway, new MappingTransformer());

        $result = $repository->getElementId('bel004c01');

        $this->assertInstanceOf(Mapping::class, $result);
        $this->assertMappingContent($data, $result);
    }

    protected function assertMappingContent(array $expected, Mapping $mapping): void
    {
        $this->assertInstanceOf(Item::class, $mapping->item);
        $this->assertEquals($expected['item']['no'], $mapping->item->number);
        $this->assertEquals($expected['item']['type'], $mapping->item->type);
        $this->assertEquals($expected['color_id'], $mapping->colorId);
        $this->assertEquals($expected['color_name'], $mapping->colorName);
        $this->assertEquals($expected['element_id'], $mapping->elementId);
    }
}
