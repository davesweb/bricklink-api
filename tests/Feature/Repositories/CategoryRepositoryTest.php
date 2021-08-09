<?php

namespace Davesweb\BrinklinkApi\Tests\Feature\Repositories;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\Repositories\CategoryRepository;

/**
 * @internal
 * @coversNothing
 */
class CategoryRepositoryTest extends TestCase
{
    public function testItReturnsIndex(): void
    {
        $repository = new CategoryRepository(new TestBricklinkGateway(null));

        $results = $repository->index();

        $this->assertIsIterable($results);
    }
}
