<?php

use Api\Dish\AppBuilder;

require_once __DIR__ . '/../app/bootstrap.php';

(new AppBuilder(dirname(__DIR__, 3), dirname(__DIR__)))->build()->run();