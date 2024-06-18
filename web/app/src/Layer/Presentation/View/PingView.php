<?php

namespace Api\Dish\Layer\Presentation\View;

class PingView
{
    public function toArray(string $name): array
    {
        return [
            'hello' => $name
        ];
    }
}