<?php

namespace Api\Dish\Layer\Persistence\Action\Ingredient;

use Api\Dish\Layer\Domain\Ingredient\Entity\Ingredient;
use Api\Dish\Layer\Domain\Ingredient\GetAllIngredientByTypeIdInterface;
use Api\Dish\Layer\Persistence\Entity\IngredientEntity;
use Api\Dish\Layer\Persistence\Model\IngredientModel;
use Api\Dish\Layer\Persistence\Repository\IngredientRepository;

class GetAllIngredientByTypeIdAction implements GetAllIngredientByTypeIdInterface
{
    private IngredientRepository $ingredientRepository;
    private IngredientModel $ingredientModel;

    public function __construct(
        IngredientRepository $ingredientRepository,
        IngredientModel $ingredientModel
    ) {
        $this->ingredientRepository = $ingredientRepository;
        $this->ingredientModel = $ingredientModel;
    }

    /**
     * @param int $typeId
     * @return Ingredient[]
     */
    public function get(int $typeId): array
    {
        return array_map(
            fn(IngredientEntity $entity) => $this->ingredientModel->toDomain($entity),
            $this->ingredientRepository->getIngredientsByTypeId($typeId)
        );
    }
}