<?php

namespace Api\Dish;

use Dotenv\Dotenv;

class AppConfigurator
{
    public static function configure(): void
    {
        static::initRequestId();
        static::initPHPConfiguration();
        static::loadDotEnv();
    }

    protected static function initRequestId(): void
    {
        if (empty(getenv('REQUEST_ID'))) {
            putenv(sprintf('REQUEST_ID=%s', md5(uniqid('api_dishdesigner', true))));
            $_SERVER['REQUEST_ID'] = getenv('REQUEST_ID');
        }
    }

    protected static function initPHPConfiguration(): void
    {
        ini_set('zend.exception_ignore_args', 'Off');
        ini_set('serialize_precision', '14');
        bcscale(2);
    }

    protected static function loadDotEnv(): void
    {
        $dotenv = Dotenv::createUnsafeImmutable(dirname(__DIR__, 2));
//        dd($dotenv);
        $dotenv->load();
    }
}
