<?php

use Api\Dish\AppConfigurator;

require_once __DIR__ . '/vendor/autoload.php';

ini_set('max_execution_time', '300');

AppConfigurator::configure();
