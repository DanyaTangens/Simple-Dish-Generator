<?php

namespace Api\Dish\Dependency;

use DI\Container as DIContainer;
use DI\DependencyException;
use DI\NotFoundException;

class Container implements ContainerInterface
{
    private DIContainer $container;

    public function __construct(DIContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @template T
     * @param class-string<T> $id
     * @return T
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function get(string $id)
    {
        return $this->container->get($id);
    }

    public function has(string $id): bool
    {
        return $this->container->has($id);
    }

    /**
     * @param string $id
     * @param $value
     * @return void
     */
    public function inject(string $id, $value): void
    {
        $this->container->set($id, $value);
    }

    /**
     * @param string $id
     * @param array $parameters
     * @return mixed
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function factory(string $id, array $parameters = []): mixed
    {
        return $this->container->make($id, $parameters);
    }

    /**
     * Костыль для \DI\Bridge\Slim\Bridge ему нужен метод set
     * @param string $id
     * @param $value
     * @return void
     */
    public function set(string $id, $value): void
    {
        $this->container->set($id, $value);
    }
}
