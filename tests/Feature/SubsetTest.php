<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\ValueObjects\Item;
use Davesweb\BrinklinkApi\ValueObjects\Entry;
use Davesweb\BrinklinkApi\ValueObjects\Subset;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\Repositories\SubsetRepository;
use Davesweb\BrinklinkApi\Transformers\SubsetTransformer;

/**
 * @internal
 * @coversNothing
 */
class SubsetTest extends TestCase
{
    public function testItReturnsSubsets(): void
    {
        $data       = $this->getDataArray('subset');
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new SubsetRepository($gateway, new SubsetTransformer());

        $results = $repository->index(1234);

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(Subset::class, $results[0]);
        $this->assertSubsetContent($data, $results[0]);
    }

    protected function assertSubsetContent(array $expected, Subset $subset): void
    {
        $this->assertEquals($expected['match_no'], $subset->matchNumber);
        $this->assertIsIterable($subset->entries);
        $this->assertGreaterThan(0, count($subset->entries));

        for ($i = 0; $i < count($expected['entries']); ++$i) {
            $this->assertInstanceOf(Entry::class, $subset->entries[$i]);
            $this->assertInstanceOf(Item::class, $subset->entries[$i]->item);
            $this->assertEquals($expected['entries'][$i]['item']['no'], $subset->entries[$i]->item->number);
            $this->assertEquals($expected['entries'][$i]['item']['name'], $subset->entries[$i]->item->name);
            $this->assertEquals($expected['entries'][$i]['item']['type'], $subset->entries[$i]->item->type);
            $this->assertEquals($expected['entries'][$i]['item']['categoryID'], $subset->entries[$i]->item->categoryId);
            $this->assertEquals($expected['entries'][$i]['color_id'], $subset->entries[$i]->colorId);
            $this->assertEquals($expected['entries'][$i]['quantity'], $subset->entries[$i]->quantity);
            $this->assertEquals($expected['entries'][$i]['extra_quantity'], $subset->entries[$i]->extraQuantity);
            $this->assertEquals($expected['entries'][$i]['is_alternate'], $subset->entries[$i]->isAlternate);
            $this->assertEquals($expected['entries'][$i]['is_counterpart'], $subset->entries[$i]->isCounterpart);
        }
    }
}
