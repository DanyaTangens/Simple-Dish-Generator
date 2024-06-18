<?php

namespace Api\Dish\Layer\Domain\IngredientType;

use Api\Dish\Layer\Domain\IngredientType\Entity\IngredientType;

interface GetAllIngredientTypeInterface
{
    /**
     * @return IngredientType[]
     */
    public function get(): array;
}
