<?php

namespace Davesweb\BrinklinkApi\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\ParameterObjects\ItemType;

/**
 * @internal
 * @coversNothing
 */
class ItemTypeTest extends TestCase
{
    public function testItCreatesADefaultItemType(): void
    {
        $status = ItemType::default();

        $this->assertEquals('', (string) $status);
    }

    public function testItCreatesASingleItemType(): void
    {
        $status = ItemType::make()->part();

        $this->assertEquals('PART', (string) $status);
    }

    public function testItCreatesMultipleItemTypes(): void
    {
        $status = ItemType::make()->part()->minifig()->set();

        $this->assertEquals('PART,MINIFIG,SET', (string) $status);
    }

    public function testItCanExcludeItemTypes(): void
    {
        $status = ItemType::make()->PART()->withoutGear()->withoutBook();

        $this->assertEquals('PART,-GEAR,-BOOK', (string) $status);
    }
}
