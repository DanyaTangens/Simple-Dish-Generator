<?php

use Doctrine\DBAL\DriverManager;

require_once __DIR__ . '/../bootstrap.php';

// :)
$connection = DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'dbname' => getenv('DB_NAME'),
    'user' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'host' => getenv('DB_HOST'),
    'port' => getenv('DB_PORT'),
]);

$sql[] = <<<SQL
    DROP TABLE IF EXISTS test_task.ingredient;
SQL;

$sql[] = <<<SQL
    DROP TABLE IF EXISTS test_task.ingredient_type;
SQL;

$sql[] = <<<SQL
CREATE TABLE test_task.ingredient_type (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) DEFAULT NULL,
  code CHAR(1) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 4,
CHARACTER SET utf8mb4,
COLLATE utf8mb4_0900_ai_ci;

SQL;

$sql[] = <<<SQL
CREATE TABLE test_task.ingredient (
  id INT NOT NULL AUTO_INCREMENT,
  type_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  price DECIMAL(19, 2) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 10,
CHARACTER SET utf8mb4,
COLLATE utf8mb4_0900_ai_ci;
SQL;

$sql[] = <<<SQL
ALTER TABLE test_task.ingredient 
  ADD CONSTRAINT FK_ingredient_type_id FOREIGN KEY (type_id)
    REFERENCES test_task.ingredient_type(id);
SQL;

$sql[] = <<<SQL
INSERT INTO test_task.ingredient_type VALUES
(1, 'Тесто', 'd'),
(2, 'Сыр', 'c'),
(3, 'Начинка', 'i');

SQL;

$sql[] = <<<SQL
INSERT INTO test_task.ingredient VALUES
(1, 1, 'Тонкое тесто', 100.00),
(2, 1, 'Пышное тесто', 110.00),
(3, 1, 'Ржаное тесто', 150.00),
(4, 2, 'Моцарелла', 50.00),
(5, 2, 'Рикотта', 70.00),
(6, 3, 'Колбаса', 30.00),
(7, 3, 'Ветчина', 35.00),
(8, 3, 'Грибы', 50.00),
(9, 3, 'Томаты', 10.00);
SQL;

foreach ($sql as $query) {
    $connection->executeQuery($query);
}
