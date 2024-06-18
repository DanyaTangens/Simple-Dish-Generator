<?php

namespace Api\Dish;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App as SlimApp;

class HttpApp implements RequestHandlerInterface
{
    private SlimApp $slimApp;

    public function __construct(SlimApp $slimApp)
    {
        $this->slimApp = $slimApp;
    }

    public function run(): void
    {
        $this->slimApp->run();
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->slimApp->handle($request);
    }
}
