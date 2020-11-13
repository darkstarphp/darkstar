<?php

declare(strict_types = 1);

/**
 * DarkStar framework
 * by Zsolt Sándor <hello@elevenone.space>
 *
 * @link https://elevenone.space
 * @license MIT
 */

namespace DarkStar;

use DarkStar\Exception\Application\DarkStarException;
use DarkStar\Exception\ExceptionHandlerInterface;
use DarkStar\Exception\Http\BadRequestException;
use DarkStar\Exception\Http\MethodNotAllowedException;
use DarkStar\Exception\Http\NotFoundException;
use DarkStar\Http\Request;
use DarkStar\Http\Response;
use DarkStar\Logger\LoggerInterface;
use DarkStar\Router\RouterInterface;
use DarkStar\Router\Router;

class Application
{
    /**
     * @var array $config
     */
    public $config;

    /**
     * @var Request $request
     */
    public $request;

    /**
     * @var RouterInterface $router
     */
    public $router;

    /**
     * @var LoggerInterface $logger
     */
    public $logger;

    /**
     * @var ExceptionHandlerInterface $exceptionHandler
     */
    public $exceptionHandler;

    public function __construct(
        array $config,
        Request $request,
        RouterInterface $router,
        LoggerInterface $logger,
        ExceptionHandlerInterface $exceptionHandler
    ) {
        $this->config = $config;
        $this->router = $router;
        $this->request = $request;
        $this->logger = $logger;
        $this->exceptionHandler = $exceptionHandler;
    }

    /**
     * Runs the application and passes all errors to exception handler.
     *
     * @return Response
     */
    public function run(): Response
    {
        try {
            $response = $this->dispatch();
            $this->send($response);
        } catch (\Error $e) {
            $response = $this->exceptionHandler->handleError($e);
            $this->send($response);
        } catch (\Exception $e) {
            $response = $this->exceptionHandler->handleException($e);
            $this->send($response);
        }

        return $response;
    }

    /**
     * Analyzes the request using the router and calls corresponding action.
     * Throws HTTP exceptions in case request could not be assigned to an action.

     * @throws BadRequestException
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @throws DarkStarException
     * @return Response
     */
    protected function dispatch(): Response
    {
        $httpMethod = $this->request->getRequestMethod();
        $uri = $this->request->getRequestUri();
        $routeInfo = $this->router->dispatch($httpMethod, $uri);
        if (!isset($routeInfo[0])) {
            throw new BadRequestException('Unable to parse request.');
        }
        switch ($routeInfo[0]) {
            case Router::NOT_FOUND:
                throw new NotFoundException('Page not found.');
            case Router::METHOD_NOT_ALLOWED:
                throw new MethodNotAllowedException('Method not allowed');
            case Router::FOUND:
                $action = $routeInfo[1];
                $arguments = $routeInfo[2];
                return $this->callAction($action, $arguments);
            default:
                throw new BadRequestException('Unable to parse request.');
        }
    }

    /**
     * Calls an action.
     *
     * @param string $handler
     * @param array $arguments
     * @throws DarkStarException
     * @return Response
     */
    public function callAction(string $handler, array $arguments = []): Response
    {
        if (!class_exists($handler)) {
            throw new DarkStarException('Action class not found.');
        }

        /** @var \DarkStar\Action\ActionInterface $action */
        $action = new $handler($this->config, $this->logger, $this->request);
        return $action->__invoke($arguments);
    }

    /**
     * Sends response to client.
     *
     * @param Response $response
     * @return void
     */
    public function send(Response $response): void
    {
        // send http header:
        $httpHeader = sprintf(
            'HTTP/%s %d %s',
            $response->getProtocolVersion(),
            $response->getStatus(),
            $response->getStatusMessage()
        );
        header($httpHeader, true);

        // send additional headers:
        foreach ($response->getHeaders() as $name => $value) {
            header(sprintf('%s: %s', $name, $value), true);
        }

        // send body:
        echo $response->getBody();
    }
}
