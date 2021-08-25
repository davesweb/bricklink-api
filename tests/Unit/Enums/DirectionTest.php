<?php

namespace Davesweb\BrinklinkApi\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\ParameterObjects\Direction;
use Davesweb\BrinklinkApi\Exceptions\InvalidDirectionException;

/**
 * @internal
 * @coversNothing
 */
class DirectionTest extends TestCase
{
    public function testItCreatesADefaultDirection(): void
    {
        $direction = Direction::default();

        $this->assertEquals(Direction::IN, (string) $direction);
    }

    public function testItCreatesADirection(): void
    {
        $direction = Direction::make()->out();

        $this->assertEquals(Direction::OUT, (string) $direction);
    }

    public function testDirectionCanBeChanged(): void
    {
        $direction = Direction::make()->in()->out();

        $this->assertEquals(Direction::OUT, (string) $direction);
    }

    public function testItThrowsOnInvalidDirection(): void
    {
        $this->expectException(InvalidDirectionException::class);

        Direction::make('left');
    }
}
