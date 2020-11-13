<?php

namespace DarkStar\Tests\Fixtures;

use DarkStar\Action\HtmlAction;
use DarkStar\Http\Response;

class HelloWorldHtmlAction extends HtmlAction
{
    public function __invoke(array $arguments = []): Response
    {
        return new Response(200, [], 'Hello World!');
    }
}
