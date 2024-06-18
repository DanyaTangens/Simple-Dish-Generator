<?php

namespace Api\Dish\Dependency;

use Api\Dish\Dependency\Definition\ActionsDefinitionTrait;
use Api\Dish\Dependency\Definition\PsrDefinitionTrait;
use Api\Dish\Dependency\Definition\StorageDefinitionTrait;
use Api\Dish\Middleware\Validation\ValidationMiddlewareBuilder;
use Exception;
use DI\ContainerBuilder as DIContainerBuilder;

final class ContainerBuilder
{
    use PsrDefinitionTrait;
    use StorageDefinitionTrait;
    use ActionsDefinitionTrait;

    public static string $rootDir;
    public static string $appRootDir;

    public function __construct(
        string $rootDir,
        string $appRootDir
    ) {
        ContainerBuilder::$rootDir = $rootDir;
        ContainerBuilder::$appRootDir = $appRootDir;
    }

    /**
     * @return ContainerInterface
     * @throws Exception
     */
    public function build(): ContainerInterface
    {
        $definitions = array_merge(
            $this->getPsrDefinitions(),
            $this->getStorageDefinitions(),
            $this->getActionDefinitions()
        );

        $containerBuilder = new DIContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $containerBuilder->addDefinitions($definitions);

        $container = $containerBuilder->build();

        return new Container($container);
    }

    public static function getValidationMiddlewareBuilder(string $yamlFile): ValidationMiddlewareBuilder
    {
        return (new ValidationMiddlewareBuilder())->fromYamlFile($yamlFile);
    }
}
