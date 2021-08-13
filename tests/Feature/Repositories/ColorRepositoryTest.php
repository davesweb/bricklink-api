<?php

namespace Davesweb\BrinklinkApi\Tests\Feature\Repositories;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\ValueObjects\Color;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Repositories\ColorRepository;
use Davesweb\BrinklinkApi\Transformers\ColorTransformer;

/**
 * @internal
 * @coversNothing
 */
class ColorRepositoryTest extends TestCase
{
    public function testItReturnsIterableIndex(): void
    {
        $data       = $this->getDataArray();
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ColorRepository($gateway, new ColorTransformer());

        $results = $repository->index();

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(Color::class, $results[0]);

        $this->assertCategoryContent($data, $results[0]);
    }

    public function testItReturnsNullWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ColorRepository($gateway, new ColorTransformer());

        $result = $repository->find(404);

        $this->assertNull($result);
    }

    public function testItThrowsWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ColorRepository($gateway, new ColorTransformer());

        $this->expectException(NotFoundException::class);

        $repository->findOrFail(404);
    }

    public function testItReturnsAColor(): void
    {
        $data       = $this->getDataArray();
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ColorRepository($gateway, new ColorTransformer());

        $result = $repository->find(3001);

        $this->assertInstanceOf(Color::class, $result);

        $this->assertCategoryContent($data, $result);
    }

    protected function assertCategoryContent(array $expected, Color $color): void
    {
        $this->assertEquals($expected['color_id'], $color->colorId);
        $this->assertEquals($expected['color_name'], $color->colorName);
        $this->assertEquals($expected['color_code'], $color->colorCode);
        $this->assertEquals($expected['color_type'], $color->colorType);
    }

    protected function getDataArray(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/../../responses/color.json'), true);
    }
}
