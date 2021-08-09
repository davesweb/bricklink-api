<?php

namespace Davesweb\BrinklinkApi\Tests\Feature\Repositories;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\ValueObjects\Category;
use Davesweb\BrinklinkApi\Repositories\CategoryRepository;

/**
 * @internal
 * @small
 * @coversNothing
 */
class CategoryRepositoryTest extends TestCase
{
    public function testItReturnsIterableIndex(): void
    {
        $repository = new CategoryRepository(new TestBricklinkGateway(BricklinkResponse::test(200, [])));

        $results = $repository->index();

        $this->assertIsIterable($results);
    }

    public function testItReturnsCategoriesIndex(): void
    {
        $response   = BricklinkResponse::test(200, [json_decode(file_get_contents(__DIR__.'/../../responses/category.json'), true)]);
        $repository = new CategoryRepository(new TestBricklinkGateway($response));

        $results = $repository->index();

        $this->assertIsIterable($results);

        $this->assertCount(1, $results);

        $this->assertInstanceOf(Category::class, $results[0]);
    }

    public function testItReturnsCategory(): void
    {
        $repository = new CategoryRepository(new TestBricklinkGateway(BricklinkResponse::test(200, json_decode(file_get_contents(__DIR__.'/../../responses/category.json'), true))));

        $result = $repository->find(10);

        $this->assertInstanceOf(Category::class, $result);
    }
}
