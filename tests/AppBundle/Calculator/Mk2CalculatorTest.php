<?php

namespace Tests\AppBundle\Calculator;

use AppBundle\Calculator\CalculatorInterface;
use AppBundle\Model\Change;
use AppBundle\Calculator\Mk2Calculator;
use PHPUnit\Framework\TestCase;

class Mk2CalculatorTest extends TestCase
{
    /**
     * @var CalculatorInterface
     */
    private $calculator;

    protected function setUp()
    {
        $this->calculator = new Mk2Calculator();
    }

    public function testGetSupportedModel()
    {
        $this->assertEquals('mk2', $this->calculator->getSupportedModel());
    }

    public function testGetChangeEasy()
    {
        $change = $this->calculator->getChange(2);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(1, $change->coin2);
    }

    public function testGetChangeImpossible()
    {
        $change = $this->calculator->getChange(1);
        $this->assertNull($change);
    }

    /**
     * @dataProvider providerHard
     *
     * @param int  $amount
     * @param bool $valid
     * @param int  $coin2
     * @param int  $bill5
     * @param int  $bill10
     */
    public function testGetChangeHard(
        int $amount,
        bool $valid,
        int $coin2,
        int $bill5,
        int $bill10)
    {

        $change = $this->calculator->getChange($amount);
        if (!$valid) {
            $this->assertNull($change);
            return;
        }

        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(0, $change->coin1);
        $this->assertEquals($coin2, $change->coin2);
        $this->assertEquals($bill5, $change->bill5);
        $this->assertEquals($bill10, $change->bill10);
    }

    /**
     * @return array
     */
    public function providerHard()
    {
        return [
            [1, false, 0, 0, 0],
            [2, true, 1, 0, 0],
            [3, false, 0, 0, 0],
            [4, true, 2, 0, 0],
            [5, true, 0, 1, 0],
            [6, true, 3, 0, 0],
            [7, true, 1, 1, 0],
            [8, true, 4, 0, 0],
            [9, true, 2, 1, 0],
            [10, true, 0, 0, 1],
            [11, true, 3, 1, 0],
            [12, true, 1, 0, 1],
            [13, true, 4, 1, 0],
            [14, true, 2, 0, 1],
            [15, true, 0, 1, 1],
            [16, true, 3, 0, 1],
            [17, true, 1, 1, 1],
            [18, true, 4, 0, 1],
            [19, true, 2, 1, 1],
            [20, true, 0, 0, 2],
        ];
    }

}