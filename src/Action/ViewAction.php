<?php

declare(strict_types = 1);

namespace DarkStar\Action;

use DarkStar\Http\Request;
use DarkStar\Log\LoggerInterface;
use DarkStar\Action\Action;
use DarkStar\Responder\ViewResponder;


/**
 * @property ViewResponder $responder
 */

abstract class ViewAction extends Action
{
    public function __construct(array $config, LoggerInterface $logger, Request $request)
    {
        parent::__construct($config, $logger, $request);
        $this->setResponder(new ViewResponder($config));
    }
}
