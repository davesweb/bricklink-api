<?php

namespace Davesweb\BrinklinkApi\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\Enums\OrderStatus;

/**
 * @internal
 * @coversNothing
 */
class OrderStatusTest extends TestCase
{
    public function testItCreatesADefaultStatus(): void
    {
        $status = OrderStatus::default();

        $this->assertEquals('', (string) $status);
    }

    public function testItCreatesASingleStatus(): void
    {
        $status = OrderStatus::make()->received();

        $this->assertEquals('Received', (string) $status);
    }

    public function testItCreatesMultipleStatuses(): void
    {
        $status = OrderStatus::make()->received()->updated()->completed();

        $this->assertEquals('Received,Updated,Completed', (string) $status);
    }

    public function testItCanExcludeStatuses(): void
    {
        $status = OrderStatus::make()->received()->withoutCancelled()->withoutNpb();

        $this->assertEquals('Received,-Cancelled,-NPB', (string) $status);
    }
}
