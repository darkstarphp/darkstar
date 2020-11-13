<?php

declare(strict_types = 1);

namespace DarkStar\Exception\Application;

/**
 * This exception is thrown in case DarkStar application needs to abort processing and can handle the error within
 * the application itself.
 */
class DarkStarException extends \Exception
{
}
