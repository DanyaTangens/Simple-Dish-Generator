<?php

namespace Api\Dish\Layer\Domain\Ingredient;

use Api\Dish\Layer\Domain\Ingredient\Entity\Ingredient;

interface GetAllIngredientByTypeIdInterface
{
    /**
     * @param int $typeId
     * @return Ingredient[]
     */
    public function get(int $typeId): array;
}
