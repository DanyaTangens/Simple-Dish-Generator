<?php

namespace Api\Dish\Dependency\Definition;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

trait StorageDefinitionTrait
{
    /**
     * @return Closure[]
     */
    public function getStorageDefinitions(): array
    {
        return [
            Connection::class => function () {
                $params = [
                    'driver' => 'pdo_mysql',
                    'user' => getenv('DB_USER'),
                    'password' => getenv('DB_PASSWORD'),
                    'host' => getenv('DB_HOST'),
                    'port' => getenv('DB_PORT'),
                ];

                return DriverManager::getConnection($params);
            },
        ];
    }
}