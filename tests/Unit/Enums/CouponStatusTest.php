<?php

namespace Davesweb\BrinklinkApi\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\ParameterObjects\CouponStatus;

/**
 * @internal
 * @coversNothing
 */
class CouponStatusTest extends TestCase
{
    public function testItCreatesADefaultStatus(): void
    {
        $status = CouponStatus::default();

        $this->assertEquals('', (string) $status);
    }

    public function testItCreatesASingleStatus(): void
    {
        $status = CouponStatus::make()->open();

        $this->assertEquals('O', (string) $status);
    }

    public function testItCreatesMultipleStatuses(): void
    {
        $status = CouponStatus::make()->open()->denied()->expired();

        $this->assertEquals('O,D,E', (string) $status);
    }

    public function testItCanExcludeStatuses(): void
    {
        $status = CouponStatus::make()->open()->withoutDenied()->withoutExpired();

        $this->assertEquals('O,-D,-E', (string) $status);
    }
}
