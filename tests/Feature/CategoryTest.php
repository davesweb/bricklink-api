<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\ValueObjects\Category;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Repositories\CategoryRepository;
use Davesweb\BrinklinkApi\Transformers\CategoryTransformer;

/**
 * @internal
 * @small
 * @coversNothing
 */
class CategoryTest extends TestCase
{
    public function testItReturnsIterableIndex(): void
    {
        $repository = new CategoryRepository(new TestBricklinkGateway(BricklinkResponse::test(200, [])), new CategoryTransformer());

        $results = $repository->index();

        $this->assertIsIterable($results);
    }

    public function testItReturnsCategoriesIndex(): void
    {
        $data       = $this->getDataArray('category');
        $response   = BricklinkResponse::test(200, [$data]);
        $repository = new CategoryRepository(new TestBricklinkGateway($response), new CategoryTransformer());

        $results = $repository->index();

        $this->assertIsIterable($results);

        $this->assertCount(1, $results);

        $this->assertInstanceOf(Category::class, $results[0]);

        $this->assertCategoryContent($data, $results[0]);
    }

    public function testItReturnsNullWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CategoryRepository($gateway, new CategoryTransformer());

        $result = $repository->find(404);

        $this->assertNull($result);
    }

    public function testItThrowsWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new CategoryRepository($gateway, new CategoryTransformer());

        $this->expectException(NotFoundException::class);

        $repository->findOrFail(404);
    }

    public function testItReturnsACategory(): void
    {
        $data = $this->getDataArray('category');

        $repository = new CategoryRepository(
            new TestBricklinkGateway(BricklinkResponse::test(200, $data)),
            new CategoryTransformer()
        );

        $result = $repository->find(10);

        $this->assertInstanceOf(Category::class, $result);
        $this->assertCategoryContent($data, $result);
    }

    protected function assertCategoryContent(array $expected, Category $category): void
    {
        $this->assertEquals($expected['category_id'], $category->categoryId);
        $this->assertEquals($expected['category_name'], $category->categoryName);
        $this->assertEquals($expected['parent_id'], $category->parentId);
    }
}
