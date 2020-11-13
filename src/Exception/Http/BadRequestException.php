<?php

declare(strict_types = 1);

namespace DarkStar\Exception\Http;

/**
 * Class BadRequestException
 *
 * This exception should be thrown in case of a bad http request (http error 400).
 *
 * @package DarkStar\Exception\Http
 */
class BadRequestException extends HttpException
{
}
