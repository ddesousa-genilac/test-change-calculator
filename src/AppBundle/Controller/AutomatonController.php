<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Registry\CalculatorRegistryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AutomatonController.
 */
class AutomatonController
{
    /**
     * @var CalculatorRegistryInterface
     */
    private $calculatorRegistry;

    /**
     * AutomatonController constructor.
     *
     * @param CalculatorRegistryInterface $calculatorRegistry
     */
    public function __construct(CalculatorRegistryInterface $calculatorRegistry)
    {
        $this->calculatorRegistry = $calculatorRegistry;
    }

    /**
     * @Route("/automaton/{model}/change/{amount}", requirements={"model"="\w+", "amount"="\w+"})
     *
     * @param string $model
     * @param int    $amount
     *
     * @return JsonResponse
     */
    public function __invoke(string $model, int $amount)
    {
        // find calculator
        $calculator = $this->calculatorRegistry->getCalculatorFor($model);
        if (!$calculator) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        // compute change
        $change = $calculator->getChange($amount);

        return new JsonResponse($change, $change ? JsonResponse::HTTP_OK : JsonResponse::HTTP_NO_CONTENT);
    }
}
