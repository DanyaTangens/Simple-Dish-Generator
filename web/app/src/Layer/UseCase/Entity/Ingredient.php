<?php

namespace Api\Dish\Layer\UseCase\Entity;

class Ingredient
{
    private string $type;
    private string $value;
    private int $ingredientId;
    private float $price;

    public function __construct(string $type, string $value, int $ingredientId, float $price)
    {
        $this->type = $type;
        $this->value = $value;
        $this->ingredientId = $ingredientId;
        $this->price = $price;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getIngredientId(): int
    {
        return $this->ingredientId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
