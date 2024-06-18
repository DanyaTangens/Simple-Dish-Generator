<?php

namespace Api\Dish\Layer\Persistence\Entity;

class IngredientTypeEntity
{
    private int $id;
    private string $title;
    private string $code;

    public function __construct(int $id, string $title, string $code)
    {
        $this->id = $id;
        $this->title = $title;
        $this->code = $code;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
