<?php

namespace Api\Dish\Middleware\Validation;

use cebe\openapi\spec\OpenApi;
use League\OpenAPIValidation\PSR7\ValidatorBuilder as PSRValidatorBuilder;
use Psr\Http\Server\MiddlewareInterface;

class ValidationMiddlewareBuilder extends PSRValidatorBuilder
{
    public function getValidationMiddleware(): MiddlewareInterface {
        return new ValidationMiddleware(
            $this->getServerRequestValidator(),
            $this->getResponseValidator()
        );
    }

    public function getSchema(): OpenApi
    {
        return $this->getOrCreateSchema();
    }
}
