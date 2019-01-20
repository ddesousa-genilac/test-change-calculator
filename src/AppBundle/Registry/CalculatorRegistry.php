<?php

declare(strict_types=1);

namespace AppBundle\Registry;

use AppBundle\Calculator\CalculatorInterface;

/**
 * Class CalculatorRegistry.
 */
class CalculatorRegistry implements CalculatorRegistryInterface
{
    /**
     * @var CalculatorInterface[]
     */
    private $calculators = [];

    /**
     * CalculatorRegistry constructor.
     *
     * @param iterable $calculators
     */
    public function __construct(iterable $calculators)
    {
        // add calculator into registry
        foreach ($calculators as $calculator) {
            if ($calculator instanceof CalculatorInterface) {
                $this->calculators[] = $calculator;
            }
        }
    }

    /**
     * @param string $model Indicates the model of automaton
     *
     * @return CalculatorInterface|null The calculator, or null if no CalculatorInterface supports that model
     */
    public function getCalculatorFor(string $model): ?CalculatorInterface
    {
        // find calculator
        foreach ($this->calculators as $calculator) {
            if ($model === $calculator->getSupportedModel()) {
                return $calculator;
            }
        }

        return null;
    }
}
