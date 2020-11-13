<?php

return [
    'home' => [
        'method' => 'GET',
        'pattern' => '/',
        'handler' => 'DarkStar\Tests\Fixtures\HelloWorldHtmlAction',
    ],

    'invalid_action' => [
        'method' => 'GET',
        'pattern' => '/invalid-action',
        'handler' => 'DarkStar\Tests\Fixtures\InvalidAction',
    ],
];
