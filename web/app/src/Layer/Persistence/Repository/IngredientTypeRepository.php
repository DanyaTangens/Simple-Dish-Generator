<?php

namespace Api\Dish\Layer\Persistence\Repository;

use Api\Dish\Layer\Persistence\Entity\IngredientTypeEntity;
use Doctrine\DBAL\Connection;

class IngredientTypeRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getAll(): array
    {
        $sql = <<<SQL
SELECT 
    id,
    title,
    code
FROM 
    test_task.ingredient_type
SQL;

        $result = [];
        foreach ($this->connection->fetchAllAssociative($sql) as $row) {
            $result[] = $this->makeFromRow($row);
        }

        return $result;
    }

    private function makeFromRow(array $row): IngredientTypeEntity
    {
        return new IngredientTypeEntity(
            (int)$row['id'],
            (string)$row['title'],
            (string)$row['code']
        );
    }
}
