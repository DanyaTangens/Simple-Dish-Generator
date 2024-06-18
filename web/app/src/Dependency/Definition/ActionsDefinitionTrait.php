<?php

namespace Api\Dish\Dependency\Definition;

use Api\Dish\Layer\Domain\Ingredient\GetAllIngredientByTypeIdInterface;
use Api\Dish\Layer\Domain\IngredientType\GetAllIngredientTypeInterface;
use Api\Dish\Layer\Persistence\Action\Ingredient\GetAllIngredientByTypeIdAction;
use Api\Dish\Layer\Persistence\Action\IngredientType\GetAllIngredientTypeAction;
use Api\Dish\Layer\Persistence\Model\IngredientModel;
use Api\Dish\Layer\Persistence\Model\IngredientTypeModel;
use Api\Dish\Layer\Persistence\Repository\IngredientRepository;
use Api\Dish\Layer\Persistence\Repository\IngredientTypeRepository;
use Doctrine\DBAL\Connection;

trait ActionsDefinitionTrait
{
    /**
     * @return Closure[]
     */
    public function getActionDefinitions(): array
    {
        return [
            GetAllIngredientByTypeIdInterface::class => static function (Connection $connection): GetAllIngredientByTypeIdAction {
                return new GetAllIngredientByTypeIdAction(
                    new IngredientRepository($connection),
                    new IngredientModel(),
                );
            },
            GetAllIngredientTypeInterface::class => static function (Connection $connection): GetAllIngredientTypeAction {
                return new GetAllIngredientTypeAction(
                    new IngredientTypeRepository($connection),
                    new IngredientTypeModel(),
                );
            },
        ];
    }
}