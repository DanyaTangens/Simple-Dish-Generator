<?php

namespace Api\Dish\Layer\Persistence\Repository;

use Api\Dish\Layer\Persistence\Entity\IngredientEntity;
use Doctrine\DBAL\Connection;

class IngredientRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getIngredientsByTypeId(int $typeId): array
    {
        $sql = <<<SQL
SELECT 
    id,
    type_id,
    title,
    price
FROM 
    test_task.ingredient
WHERE
    type_id = :type_id
SQL;

        $result = [];
        foreach ($this->connection->fetchAllAssociative($sql, ['type_id' => $typeId]) as $row) {
            $result[] = $this->makeFromRow($row);
        }

        return $result;
    }

    private function makeFromRow(array $row): IngredientEntity
    {
        return new IngredientEntity(
            (int)$row['id'],
            (int)$row['type_id'],
            (string)$row['title'],
            (float)$row['price']
        );
    }
}
