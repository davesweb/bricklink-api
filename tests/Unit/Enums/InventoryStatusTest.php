<?php

namespace Davesweb\BrinklinkApi\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\ParameterObjects\InventoryStatus;

/**
 * @internal
 * @coversNothing
 */
class InventoryStatusTest extends TestCase
{
    public function testItCreatesADefaultStatus(): void
    {
        $status = InventoryStatus::default();

        $this->assertEquals('', (string) $status);
    }

    public function testItCreatesASingleStatus(): void
    {
        $status = InventoryStatus::make()->available();

        $this->assertEquals('Y', (string) $status);
    }

    public function testItCreatesMultipleStatuses(): void
    {
        $status = InventoryStatus::make()->available()->inStockroomA()->inStockroomB();

        $this->assertEquals('Y,S,B', (string) $status);
    }

    public function testItCanExcludeStatuses(): void
    {
        $status = InventoryStatus::make()->available()->withoutReserved()->withoutUnavailable();

        $this->assertEquals('Y,-R,-N', (string) $status);
    }
}
