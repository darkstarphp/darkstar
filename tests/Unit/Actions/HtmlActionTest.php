<?php

namespace DarkStar\Tests\Unit\Action;

use DarkStar\Log\NullLogger;
use DarkStar\Responder\HtmlResponder;
use DarkStar\Http\Request;
use DarkStar\Tests\Fixtures\HelloWorldHtmlAction;
use PHPUnit\Framework\TestCase;

class HtmlActionTest extends TestCase
{
    public $config;

    public $logger;

    public function setUp(): void
    {
        $this->config = include SC_TESTS . '/Fixtures/config.php';
        $this->logger = new NullLogger;
    }

    public function testGetResponder()
    {
        $request = new Request;
        $action = new HelloWorldHtmlAction($this->config, $this->logger, $request);
        $this->assertInstanceOf(HtmlResponder::class, $action->getResponder());
    }
}
