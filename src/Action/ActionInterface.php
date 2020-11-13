<?php

declare(strict_types = 1);

namespace DarkStar\Action;

use DarkStar\Http\Response;

interface ActionInterface
{
    /**
     * Executes the action.
     *
     * @param array $arguments
     * @return Response
     */
    public function __invoke(array $arguments = []): Response;
}
