<?php

namespace Davesweb\BrinklinkApi\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\Enums\Id;

/**
 * @internal
 * @coversNothing
 */
class IdTest extends TestCase
{
    public function testItCreatesADefaultStatus(): void
    {
        $ids = Id::default();

        $this->assertEquals('', (string) $ids);
    }

    public function testItCreatesASingleId(): void
    {
        $ids = Id::make()->with(1);

        $this->assertEquals('1', (string) $ids);
    }

    public function testItCreatesMultipleIds(): void
    {
        $ids = Id::make()->with([1, 2, 3]);

        $this->assertEquals('1,2,3', (string) $ids);
    }

    public function testItCanExcludeId(): void
    {
        $ids = Id::make()->with(1)->without(2);

        $this->assertEquals('1,-2', (string) $ids);
    }

    public function testItCanExcludeMultipleIds(): void
    {
        $ids = Id::make()->with(1)->without([2, 3, 4]);

        $this->assertEquals('1,-2,-3,-4', (string) $ids);
    }
}
