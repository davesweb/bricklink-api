<?php

namespace Davesweb\BrinklinkApi\Tests\Unit\ParameterObjects;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\ParameterObjects\OrderPaymentStatus;

/**
 * @internal
 * @coversNothing
 */
class OrderPaymentStatusTest extends TestCase
{
    public function testItCreatesADefaultStatus(): void
    {
        $status = OrderPaymentStatus::default();

        $this->assertEquals('', (string) $status);
    }

    public function testItCreatesASingleStatus(): void
    {
        $status = OrderPaymentStatus::make()->bounced();

        $this->assertEquals('Bounced', (string) $status);
    }

    public function testItCreatesMultipleStatuses(): void
    {
        $status = OrderPaymentStatus::make()->bounced()->clearing()->received();

        $this->assertEquals('Bounced,Clearing,Received', (string) $status);
    }

    public function testItCanExcludeStatuses(): void
    {
        $status = OrderPaymentStatus::make()->bounced()->withoutClearing()->withoutNone();

        $this->assertEquals('Bounced,-Clearing,-None', (string) $status);
    }
}
