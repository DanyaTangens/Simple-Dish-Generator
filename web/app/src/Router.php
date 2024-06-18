<?php

namespace Api\Dish;

use Api\Dish\Layer\Presentation\Operation\GetAllDishesByRecipeOperation;
use Api\Dish\Layer\Presentation\Operation\PingOperation;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class Router
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function register(): void
    {
        $app = $this->app;

        $app->group('/api', function (RouteCollectorProxy $group) {

            $group->get('/ping', PingOperation::class);
            $group->get('/get-all-dishes-by-recipe', GetAllDishesByRecipeOperation::class);
        });
    }
}
