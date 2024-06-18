<?php

namespace Api\Dish\Layer\Persistence\Action\IngredientType;

use Api\Dish\Layer\Domain\IngredientType\Entity\IngredientType;
use Api\Dish\Layer\Domain\IngredientType\GetAllIngredientTypeInterface;
use Api\Dish\Layer\Persistence\Entity\IngredientTypeEntity;
use Api\Dish\Layer\Persistence\Model\IngredientTypeModel;
use Api\Dish\Layer\Persistence\Repository\IngredientTypeRepository;

class GetAllIngredientTypeAction implements GetAllIngredientTypeInterface
{
    private IngredientTypeRepository $ingredientTypeRepository;
    private IngredientTypeModel $ingredientTypeModel;

    public function __construct(
        IngredientTypeRepository $ingredientTypeRepository,
        IngredientTypeModel $ingredientTypeModel
    ) {
        $this->ingredientTypeRepository = $ingredientTypeRepository;
        $this->ingredientTypeModel = $ingredientTypeModel;
    }

    /**
     * @return IngredientType[]
     */
    public function get(): array
    {
        return array_map(
            fn(IngredientTypeEntity $entity) => $this->ingredientTypeModel->toDomain($entity),
            $this->ingredientTypeRepository->getAll()
        );
    }
}