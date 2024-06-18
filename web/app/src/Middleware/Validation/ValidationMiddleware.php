<?php

namespace Api\Dish\Middleware\Validation;

use League\OpenAPIValidation\PSR15\Exception\InvalidResponseMessage;
use League\OpenAPIValidation\PSR15\Exception\InvalidServerRequestMessage;
use League\OpenAPIValidation\PSR7\Exception\ValidationFailed;
use League\OpenAPIValidation\PSR7\ResponseValidator;
use League\OpenAPIValidation\PSR7\ServerRequestValidator;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class ValidationMiddleware implements MiddlewareInterface
{
    private ServerRequestValidator $requestValidator;
    private ResponseValidator $responseValidator;

    public function __construct(
        ServerRequestValidator $requestValidator,
        ResponseValidator $responseValidator,
    ) {
        $this->requestValidator = $requestValidator;
        $this->responseValidator = $responseValidator;
    }

    /**
     * @throws InvalidServerRequestMessage
     * @throws InvalidResponseMessage
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $matchedOASOperation = $this->requestValidator->validate($request);
        } catch (ValidationFailed $e) {
            throw InvalidServerRequestMessage::because($e);
        }

        $response = $handler->handle($request);

        try {
            $this->responseValidator->validate($matchedOASOperation, $response);
        } catch (ValidationFailed $e) {
            throw InvalidResponseMessage::because($e);
        }

        return $response;
    }
}
