<?php

namespace Api\Dish;

use Api\Dish\Dependency\ContainerBuilder;
use Api\Dish\Dependency\ContainerInterface;
use DI\Bridge\Slim\Bridge;
use Dotenv\Dotenv;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Middleware\ErrorMiddleware;

final class AppBuilder
{
    public const PROJECT_NAME = 'api-hotel';

    private string $rootDir;
    private string $appRootDir;

    public function __construct(string $rootDir, string $appRootDir)
    {
        $this->rootDir = $rootDir;
        $this->appRootDir = $appRootDir;
    }

    /**
     * @return HttpApp
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function build(): HttpApp
    {
        $this->loadEnv();

        $container = (new ContainerBuilder($this->rootDir, $this->appRootDir))->build();

        return $this->buildSlimApp($container);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function buildSlimApp(ContainerInterface $container): HttpApp
    {
        $app = Bridge::create($container);

        $app->addMiddleware(
            ContainerBuilder::getValidationMiddlewareBuilder(dirname(__DIR__) . '/docs/api.yaml')
                ->getValidationMiddleware()
        );
        $errorMiddleware = $app->addErrorMiddleware(true, true, true);
        $errorMiddleware->setDefaultErrorHandler(DefaultErrorHandler::class);

        $app->addBodyParsingMiddleware();

        $container->get(Router::class)->register();

        return new HttpApp($app);
    }

    private function loadEnv(): void
    {
        if (is_readable($this->rootDir . '/.env')) {
            $dotenv = Dotenv::createUnsafeImmutable($this->rootDir);
            $dotenv->load();

            $dotenv->required([
                'DB_HOST',
                'DB_PORT',
                'DB_USER',
                'DB_PASSWORD',
                'DB_NAME',
            ])->notEmpty();

            $dotenv
                ->required('APPLICATION_ENV')
                ->allowedValues(['development', 'production']);
        }
    }
}
