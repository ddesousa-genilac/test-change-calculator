<?php

declare(strict_types=1);

namespace AppBundle\Calculator;

use AppBundle\Model\Change;

/**
 * Class Mk2Calculator.
 */
class Mk2Calculator implements CalculatorInterface
{
    /**
     * @return string Indicates the model of automaton
     */
    public function getSupportedModel(): string
    {
        return 'mk2';
    }

    /**
     * @param int $amount The amount of money to turn into change
     *
     * @return Change|null The change, or null if the operation is impossible
     */
    public function getChange(int $amount): ?Change
    {
        $change = new Change();

        while ($amount >= 2) {
            if (10 === $amount || 15 <= $amount) {
                $change->bill10++;
                $amount -= 10;
            } elseif (5 === $amount || $amount % 2) {
                $change->bill5++;
                $amount -= 5;
            } else {
                $change->coin2++;
                $amount -= 2;
            }
        }

        // rest not allowed
        if ($amount) {
            return null;
        }

        return $change;
    }
}
