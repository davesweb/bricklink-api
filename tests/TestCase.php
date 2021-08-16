<?php

namespace Davesweb\BrinklinkApi\Tests;

use PHPUnit\Framework\TestCase as UnitTestCase;

abstract class TestCase extends UnitTestCase
{
    protected function getDataArray(string $filename): array
    {
        return json_decode(file_get_contents(__DIR__ . '/responses/' . $filename . '.json'), true);
    }
}
