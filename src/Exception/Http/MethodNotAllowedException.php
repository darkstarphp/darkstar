<?php

declare(strict_types = 1);

namespace DarkStar\Exception\Http;

/**
 * Class MethodNotAllowedException
 *
 * This exception should be thrown in case of a "method not allowed" error (http error 405).
 *
 * @package DarkStar\Exception\Http
 */
class MethodNotAllowedException extends HttpException
{
}
