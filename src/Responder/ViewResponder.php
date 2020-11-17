<?php

declare(strict_types = 1);

/**
 * DarkStar framework
 * by Zsolt Sándor <hello@elevenone.space>
 *
 * @link https://elevenone.space
 * @license MIT
 */

namespace DarkStar\Responder;

use DarkStar\View\ViewFactory;
use DarkStar\Responder\HtmlResponder;
use DarkStar\Http\Response;
use DarkStar\Payload\Payload;
use DarkStar\Payload\Status;


class ViewResponder extends HtmlResponder
{
    public function __construct(array $config)
    {
       // parent::__construct($config);
       $this->config = $config;
       $this->setResponse(new \DarkStar\Http\Response);

        $this->response->addHeader('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * Generates a payload response.
     *
     * @param Payload $payload
     * @return Response
     */
    public function __invoke(Payload $payload): Response
    {
        // payload
        $payloadResult = $payload->getResult();

        if ($payload->getStatus() === Status::FOUND) {
            return $this->found($payloadResult);
        }

        if ($payload->getStatus() === Status::NOT_FOUND) {
            return $this->notFound();
        }

        return $this->error([$payloadResult['error'] ?? 'Unknown Error']);
    }



    /**
     * Renders view defined in data array and passes it to http-responder.
     *
     * @param array $data
     * @return Response
     */
    public function found(array $data): Response
    {
        $this->response->setStatus(200);
        $this->response->setBody($data['body'] ?? '');
        return $this->response;
    }

    /**
     * Respond with an error message.
     *
     * @return Response
     */
    public function badRequest(): Response
    {
        $this->response->setStatus(400);
        $this->response->setBody('<html><title>400 Bad Request</title>400 Bad Request</html>');
        return $this->response;
    }

    /**
     * Respond with an not found message.
     *
     * @return Response
     */
    public function notFound(): Response
    {
        $this->response->setStatus(404);
        $this->response->setBody('<html><title>404 Not found</title>404 Not found</html>');
        return $this->response;
    }

    /**
     * Respond with an error message.
     *
     * @return Response
     */
    public function methodNotAllowed(): Response
    {
        $this->response->setStatus(405);
        $this->response->setBody('<html><title>405 Method not allowed</title>405 Method not allowed</html>');
        return $this->response;
    }

    /**
     * Respond with an error message.
     *
     * @param array $errors
     * @return Response
     */
    public function error(array $errors): Response
    {
        $this->response->setStatus(500);
        $bodyTemplate = '<html><title>Error 500</title><h1>Server Error</h1><pre>%s</pre></html>';
        $this->response->setBody(sprintf($bodyTemplate, print_r($errors, true)));
        return $this->response;
    }




}
