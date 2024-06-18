<?php

namespace Api\Dish\Dependency\Definition;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use GuzzleHttp\Psr7\HttpFactory;

trait PsrDefinitionTrait
{
    /**
     * @return Closure[]
     */
    public function getPsrDefinitions(): array
    {
        return [
            ResponseFactoryInterface::class => static function (): ResponseFactoryInterface {
                return new HttpFactory();
            },

            RequestFactoryInterface::class => static function (): RequestFactoryInterface {
                return new HttpFactory();
            },
        ];
    }
}