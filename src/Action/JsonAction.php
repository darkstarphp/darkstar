<?php

declare(strict_types = 1);

namespace DarkStar\Action;

use DarkStar\Http\Request;
use DarkStar\Log\LoggerInterface;
use DarkStar\Responder\JsonResponder;

/**
 * @property JsonResponder $responder
 */

abstract class JsonAction extends Action
{
    public function __construct(array $config, LoggerInterface $logger, Request $request)
    {
        parent::__construct($config, $logger, $request);
        $this->setResponder(new JsonResponder($config));
    }
}
