<?php

namespace Api\Dish\Layer\Domain\Ingredient\Entity;

class Ingredient
{
    private int $id;
    private int $type_id;
    private string $title;
    private float $price;

    public function __construct(int $id, int $type_id, string $title, float $price)
    {
        $this->id = $id;
        $this->type_id = $type_id;
        $this->title = $title;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTypeId(): int
    {
        return $this->type_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
