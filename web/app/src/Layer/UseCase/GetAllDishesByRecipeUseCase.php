<?php

namespace Api\Dish\Layer\UseCase;

use Api\Dish\Layer\Domain\Ingredient\Entity\Ingredient;
use Api\Dish\Layer\Domain\Ingredient\GetAllIngredientByTypeIdInterface;
use Api\Dish\Layer\Domain\IngredientType\Entity\IngredientType;
use Api\Dish\Layer\Domain\IngredientType\GetAllIngredientTypeInterface;
use Api\Dish\Layer\UseCase\Entity\Ingredient as ProductIngredient;
use Api\Dish\Layer\UseCase\Entity\Product;
use Exception;

class GetAllDishesByRecipeUseCase
{
    private GetAllIngredientTypeInterface $getAllIngredientType;
    private GetAllIngredientByTypeIdInterface $getAllIngredientByTypeId;

    public function __construct(
        GetAllIngredientTypeInterface $getAllIngredientType,
        GetAllIngredientByTypeIdInterface $getAllIngredientByTypeId
    ) {
        $this->getAllIngredientType = $getAllIngredientType;
        $this->getAllIngredientByTypeId = $getAllIngredientByTypeId;
    }

    /**
     * @param string $recipe
     * @return Product[]
     * @throws Exception
     */
    public function run(string $recipe): array
    {
        $products = [];

        $ingredientTypes = [];
        foreach ($this->getAllIngredientType->get() as $ingredientType) {
            $ingredientTypes[$ingredientType->getCode()] = $ingredientType;
        }

        $existingIngredientTypes = array_map(
            static fn(IngredientType $ingredientType): string => $ingredientType->getCode(),
            $ingredientTypes
        );

        $individualRecipeIngredients = str_split($recipe);

        $diffRecipe = array_diff($individualRecipeIngredients, $existingIngredientTypes);

        if (count($diffRecipe) > 0) {
            throw new Exception(sprintf(
                'Найдены неверные тип ингредиентов: %s',
                implode(',', array_unique($diffRecipe))
            ));
        }

        $ingredients = [];
        foreach ($ingredientTypes as $ingredientType) {
            $ingredients[$ingredientType->getCode()] = $this->getAllIngredientByTypeId->get($ingredientType->getId());
        }

        $this->getCombinations($products, $ingredients, $ingredientTypes, $individualRecipeIngredients);

        return $this->filterDuplicateIngredients($products, $individualRecipeIngredients);
    }

    /**
     * @param Product[] $products
     * @param Ingredient[] $ingredients
     * @param IngredientType[] $ingredientTypes
     * @param string[] $individualRecipeIngredients
     * @param int $index
     * @param ProductIngredient[] $combination
     * @return void
     */
    private function getCombinations(
        array &$products,
        array $ingredients,
        array $ingredientTypes,
        array $individualRecipeIngredients,
        int $index = 0,
        array $combination = []
    ): void {
        if ($index == count($individualRecipeIngredients)) {
            $products[$this->makeKey($combination)] = new Product($combination, $this->getTotalPriceByDish($combination));
            return;
        }

        $ingredientCode = $individualRecipeIngredients[$index];

        /** @var Ingredient $ingredient */
        foreach ($ingredients[$ingredientCode] as $ingredient) {
            $newCombination = $combination;
            $newCombination[] = new ProductIngredient(
                $ingredientTypes[$ingredientCode]->getTitle(),
                $ingredient->getTitle(),
                $ingredient->getId(),
                $ingredient->getPrice()
            );

            $this->getCombinations(
                $products,
                $ingredients,
                $ingredientTypes,
                $individualRecipeIngredients,
                $index + 1,
                $newCombination
            );
        }
    }

    /**
     * @param ProductIngredient[] $productIngredients
     * @return string
     */
    private function makeKey(array $productIngredients): string
    {
        return implode('#', array_map(
            static fn(ProductIngredient $productIngredient): int => $productIngredient->getIngredientId(),
            $productIngredients
        ));
    }

    /**
     * @param ProductIngredient[] $productIngredients
     * @return float
     */
    private function getTotalPriceByDish(array $productIngredients): float
    {
        $totalPrice = 0.0;
        foreach ($productIngredients as $ingredient) {
            $totalPrice = bcadd($totalPrice, $ingredient->getPrice());
        }

        return (float)$totalPrice;
    }

    /**
     * @param Product[] $products
     * @param string[] $individualRecipeIngredients
     * @return Product[]
     */
    private function filterDuplicateIngredients(array $products, array $individualRecipeIngredients): array
    {
        foreach ($products as $key => $product) {
            if (count($individualRecipeIngredients) !== count(array_unique(explode('#', $key)))) {
                unset($products[$key]);
            }
        }

        return $products;
    }
}