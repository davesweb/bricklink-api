<?php

namespace Davesweb\BrinklinkApi\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\ParameterObjects\GuideType;
use Davesweb\BrinklinkApi\Exceptions\InvalidGuideTypeException;

/**
 * @internal
 * @coversNothing
 */
class GuideTypeTest extends TestCase
{
    public function testItCreatesADefaultType(): void
    {
        $type = GuideType::default();

        $this->assertEquals(GuideType::STOCK, (string) $type);
    }

    public function testItCreatesADirection(): void
    {
        $type = GuideType::make()->sold();

        $this->assertEquals(GuideType::SOLD, (string) $type);
    }

    public function testDirectionCanBeChanged(): void
    {
        $type = GuideType::make()->sold()->stock();

        $this->assertEquals(GuideType::STOCK, (string) $type);
    }

    public function testItThrowsOnInvalidDirection(): void
    {
        $this->expectException(InvalidGuideTypeException::class);

        GuideType::make('for rent');
    }
}
