<?php

namespace Api\Dish\Layer\UseCase\Entity;

class Product
{
    private array $ingredients;
    private float $price;

    /**
     * @param Ingredient[] $ingredients
     * @param float $price
     */
    public function __construct(array $ingredients, float $price)
    {
        $this->ingredients = $ingredients;
        $this->price = $price;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}