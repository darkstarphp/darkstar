<?php

declare(strict_types = 1);

namespace DarkStar\Exception;

use DarkStar\Http\Response;
use DarkStar\Logger\LoggerInterface;
use DarkStar\Http\Request;

interface ExceptionHandlerInterface
{
    public function __construct(array $config, LoggerInterface $logger, Request $request);

    /**
     * Handles internal php errors.
     *
     * @param \Error $e
     * @return Response
     */
    public function handleError(\Error $e): Response;

    /**
     * Handles exceptions.
     *
     * @param \Exception $e
     * @return Response
     */
    public function handleException(\Exception $e): Response;
}
