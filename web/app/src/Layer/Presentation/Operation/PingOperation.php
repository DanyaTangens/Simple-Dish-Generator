<?php

namespace Api\Dish\Layer\Presentation\Operation;

use Api\Dish\Layer\Presentation\View\PingView;
use Doctrine\DBAL\Connection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PingOperation
{
    use InjectJsonInResponseTrait;

    private PingView $pingView;

    public function __construct(PingView $pingView)
    {
        $this->pingView = $pingView;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $name = $request->getQueryParams()['name'] ?? 'world';

        return $this->injectJson($response, $this->pingView->toArray($name));
    }
}
