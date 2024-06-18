<?php

namespace Api\Dish\Layer\Presentation\Operation;

use JsonException;
use Psr\Http\Message\ResponseInterface;

trait InjectJsonInResponseTrait
{
    /**
     * @param ResponseInterface $response
     * @param $data
     *
     * @return ResponseInterface
     * @throws JsonException
     */
    private function injectJson(ResponseInterface $response, $data): ResponseInterface
    {
        $body = $response->getBody();
        $body->write(json_encode($data, JSON_THROW_ON_ERROR));

        return $response
            ->withHeader('content-type', 'application/json')
            ->withBody($body);
    }
}
