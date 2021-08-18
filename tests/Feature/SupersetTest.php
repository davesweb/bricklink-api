<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\ValueObjects\Item;
use Davesweb\BrinklinkApi\ValueObjects\Entry;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\ValueObjects\Superset;
use Davesweb\BrinklinkApi\Repositories\SupersetRepository;
use Davesweb\BrinklinkApi\Transformers\SupersetTransformer;

/**
 * @internal
 * @coversNothing
 */
class SupersetTest extends TestCase
{
    public function testItReturnsSupersets(): void
    {
        $data       = $this->getDataArray('superset');
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new SupersetRepository($gateway, new SupersetTransformer());

        $results = $repository->index(1234);

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(Superset::class, $results[0]);
        $this->assertSubsetContent($data, $results[0]);
    }

    protected function assertSubsetContent(array $expected, Superset $superset): void
    {
        $this->assertEquals($expected['color_id'], $superset->colorId);
        $this->assertIsIterable($superset->entries);
        $this->assertGreaterThan(0, count($superset->entries));

        for ($i = 0; $i < count($expected['entries']); ++$i) {
            $this->assertInstanceOf(Entry::class, $superset->entries[$i]);
            $this->assertInstanceOf(Item::class, $superset->entries[$i]->item);
            $this->assertEquals($expected['entries'][$i]['item']['no'], $superset->entries[$i]->item->number);
            $this->assertEquals($expected['entries'][$i]['item']['name'], $superset->entries[$i]->item->name);
            $this->assertEquals($expected['entries'][$i]['item']['type'], $superset->entries[$i]->item->type);
            $this->assertEquals($expected['entries'][$i]['item']['categoryID'], $superset->entries[$i]->item->categoryId);
            $this->assertEquals($expected['entries'][$i]['quantity'], $superset->entries[$i]->quantity);
            $this->assertEquals($expected['entries'][$i]['appears_as'], $superset->entries[$i]->appearsAs);
        }
    }
}
