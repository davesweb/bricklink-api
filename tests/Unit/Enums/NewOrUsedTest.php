<?php

namespace Davesweb\BrinklinkApi\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use Davesweb\BrinklinkApi\ParameterObjects\NewOrUsed;
use Davesweb\BrinklinkApi\Exceptions\InvalidNewOrUsedException;

/**
 * @internal
 * @coversNothing
 */
class NewOrUsedTest extends TestCase
{
    public function testItCreatesADefaultType(): void
    {
        $type = NewOrUsed::default();

        $this->assertEquals(NewOrUsed::NEW, (string) $type);
    }

    public function testItCreatesADirection(): void
    {
        $type = NewOrUsed::make()->used();

        $this->assertEquals(NewOrUsed::USED, (string) $type);
    }

    public function testDirectionCanBeChanged(): void
    {
        $type = NewOrUsed::make()->new()->used();

        $this->assertEquals(NewOrUsed::USED, (string) $type);
    }

    public function testItThrowsOnInvalidDirection(): void
    {
        $this->expectException(InvalidNewOrUsedException::class);

        NewOrUsed::make('rented');
    }
}
