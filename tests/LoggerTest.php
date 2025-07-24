<?php

namespace Pengxul\Supports\Tests;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractHandler;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Pengxul\Supports\Logger;

class LoggerTest extends TestCase
{
    protected $logger;

    protected function setUp(): void
    {
        $this->logger = new Logger();
        $this->logger->setConfig(['file' => './test.log']);
    }

    public function testGetFormatter()
    {
        self::assertInstanceOf(FormatterInterface::class, $this->logger->getFormatter());
    }

    public function testGetHandler()
    {
        self::assertInstanceOf(AbstractHandler::class, $this->logger->getHandler());
    }

    public function testGetLogger()
    {
        self::assertInstanceOf(LoggerInterface::class, $this->logger->getLogger());
    }

    public function testDebug()
    {
        self::assertNull($this->logger->debug('test debug', ['foo' => 'bar']));
    }

    public function testInfo()
    {
        self::assertNull($this->logger->info('test info', ['foo' => 'bar']));
    }
}
