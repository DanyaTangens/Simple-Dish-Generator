<?php

namespace Api\Dish\Dependency;

use Psr\Container\ContainerInterface as PSRContainerInterface;

interface ContainerInterface extends PSRContainerInterface
{
    public function inject(string $id, mixed $value): void;

    public function factory(string $id, array $parameters = []): mixed;
}
