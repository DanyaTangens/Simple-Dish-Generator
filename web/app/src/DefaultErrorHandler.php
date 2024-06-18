<?php

namespace Api\Dish;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class DefaultErrorHandler
{
    private ResponseFactoryInterface $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(
        ServerRequestInterface $request,
        Throwable              $exception,
        bool                   $displayErrorDetails,
        bool                   $logErrors,
        bool                   $logErrorDetails,
        ?LoggerInterface       $logger = null
    ): ResponseInterface
    {
        $payload = [
            'error' => $this->resolve($exception),
        ];

        $response = $this->responseFactory->createResponse();
        $response->getBody()->write(
            json_encode($payload, JSON_UNESCAPED_UNICODE)
        );

        return $response->withStatus(500)
            ->withHeader('Content-Type', 'application/json');
    }

    private function resolve(Throwable $exception): string
    {
        return $exception->getMessage();
    }
}
