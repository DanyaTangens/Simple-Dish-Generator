<?php

namespace Api\Dish\Layer\Presentation\Operation;

use Api\Dish\Layer\Presentation\View\GetAllDishesByRecipeView;
use Api\Dish\Layer\UseCase\GetAllDishesByRecipeUseCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetAllDishesByRecipeOperation
{
    use InjectJsonInResponseTrait;

    private GetAllDishesByRecipeUseCase $allDishesByRecipeUseCase;
    private GetAllDishesByRecipeView $getAllDishesByRecipeView;

    public function __construct(
        GetAllDishesByRecipeUseCase $allDishesByRecipeUseCase,
        GetAllDishesByRecipeView $getAllDishesByRecipeView
    ) {
        $this->allDishesByRecipeUseCase = $allDishesByRecipeUseCase;
        $this->getAllDishesByRecipeView = $getAllDishesByRecipeView;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $recipe = $request->getQueryParams()['recipe'];

        $products = $this->allDishesByRecipeUseCase->run($recipe);

        return $this->injectJson($response, $this->getAllDishesByRecipeView->toArray($products));
    }
}
