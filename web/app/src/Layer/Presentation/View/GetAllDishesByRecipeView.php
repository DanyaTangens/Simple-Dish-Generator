<?php

namespace Api\Dish\Layer\Presentation\View;

use Api\Dish\Layer\UseCase\Entity\Ingredient;
use Api\Dish\Layer\UseCase\Entity\Product;

class GetAllDishesByRecipeView
{
    private const PRODUCTS = 'products';
    private const TYPE = 'type';
    private const VALUE = 'value';
    private const PRICE = 'price';

    /**
     * @param Product[] $products
     * @return array
     */
    public function toArray(array $products): array
    {
        $response = [];

        foreach ($products as $product) {
            $response[] = [
                self::PRODUCTS => array_map(fn (Ingredient $ingredient): array => $this->makeIngredients($ingredient), $product->getIngredients()),
                self::PRICE => $product->getPrice()
            ];
        }

        return $response;
    }

    private function makeIngredients(Ingredient $ingredient): array
    {
        return [
            self::TYPE => $ingredient->getType(),
            self::VALUE => $ingredient->getValue()
        ];
    }
}