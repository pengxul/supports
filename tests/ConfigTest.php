<?php

namespace Pengxul\Supports\Tests;

use PHPUnit\Framework\TestCase;
use Pengxul\Supports\Collection;
use Pengxul\Supports\Config;

class ConfigTest extends TestCase
{
    public function testBootstrap()
    {
        $config = [];

        self::assertInstanceOf(Collection::class, new Config($config));
    }
}
