<?php

namespace DarkStar\Tests\Fixtures;

use DarkStar\Action\JsonAction;
use DarkStar\Http\Response;

class HelloWorldJsonAction extends JsonAction
{
    public function __invoke(array $arguments = []): Response
    {
        return new Response(200, [], 'Hello World!');
    }
}
