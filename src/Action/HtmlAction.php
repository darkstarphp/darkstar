<?php

declare(strict_types = 1);

namespace DarkStar\Action;

use DarkStar\Http\Request;
use DarkStar\Logger\LoggerInterface;
use DarkStar\Responder\HtmlResponder;

/**
 * @property HtmlResponder $responder
 */

abstract class HtmlAction extends Action
{
    public function __construct(array $config, LoggerInterface $logger, Request $request)
    {
        parent::__construct($config, $logger, $request);
        $this->setResponder(new HtmlResponder($config));
    }
}
