<?php

namespace Api\Dish\Layer\Persistence\Model;

use Api\Dish\Layer\Domain\Ingredient\Entity\Ingredient;
use Api\Dish\Layer\Persistence\Entity\IngredientEntity;

class IngredientModel
{
    public function fromDomain(Ingredient $entity): IngredientEntity
    {
        return new IngredientEntity(
            $entity->getId(),
            $entity->getTypeId(),
            $entity->getTitle(),
            $entity->getPrice()
        );
    }

    public function toDomain(IngredientEntity $entity): Ingredient
    {
        return new Ingredient(
            $entity->getId(),
            $entity->getTypeId(),
            $entity->getTitle(),
            $entity->getPrice()
        );
    }
}