<?php

namespace Pengxul\Supports\Tests;

use PHPUnit\Framework\TestCase;

class FunctionTest extends TestCase
{
    public function testNamespace()
    {
        self::assertFalse(function_exists('collect'));
        self::assertFalse(function_exists('value'));
        self::assertFalse(function_exists('data_get'));
        self::assertTrue(function_exists('Pengxul\Supports\collect'));
        self::assertTrue(function_exists('Pengxul\Supports\value'));
        self::assertTrue(function_exists('Pengxul\Supports\data_get'));
    }
}
