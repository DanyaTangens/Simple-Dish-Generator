<?php

namespace Api\Dish\Layer\Persistence\Model;

use Api\Dish\Layer\Domain\IngredientType\Entity\IngredientType;
use Api\Dish\Layer\Persistence\Entity\IngredientTypeEntity;


class IngredientTypeModel
{
    public function fromDomain(IngredientType $entity): IngredientTypeEntity
    {
        return new IngredientTypeEntity(
            $entity->getId(),
            $entity->getTitle(),
            $entity->getCode(),
        );
    }

    public function toDomain(IngredientTypeEntity $entity): IngredientType
    {
        return new IngredientType(
            $entity->getId(),
            $entity->getTitle(),
            $entity->getCode(),
        );
    }
}