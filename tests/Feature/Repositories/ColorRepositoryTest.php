<?php

namespace Davesweb\BrinklinkApi\Tests\Feature\Repositories;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\ValueObjects\Color;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
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
        $response   = BricklinkResponse::test(200, [json_decode(file_get_contents(__DIR__ . '/../../responses/color.json'), true)]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ColorRepository($gateway, new ColorTransformer());

        $results = $repository->index();

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(Color::class, $results[0]);
    }

    public function testItReturnsNullWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ColorRepository($gateway, new ColorTransformer());

        $result = $repository->find(404);

        $this->assertNull($result);
    }

    public function testItReturnsAColor(): void
    {
        $response   = BricklinkResponse::test(200, json_decode(file_get_contents(__DIR__ . '/../../responses/color.json'), true));
        $gateway    = new TestBricklinkGateway($response);
        $repository = new ColorRepository($gateway, new ColorTransformer());

        $result = $repository->find(3001);

        $this->assertInstanceOf(Color::class, $result);
    }
}
