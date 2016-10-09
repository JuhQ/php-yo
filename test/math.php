<?php
namespace Yo;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoMath extends TestCase
{
    public function testAdd()
    {
        $yo = new Yo();
        $this->assertEquals($yo->add(1, 2), 3);
    }

    public function testSubtract()
    {
        $yo = new Yo();
        $this->assertEquals($yo->subtract(1, 2), -1);
    }

    public function testSum()
    {
        $yo = new Yo();
        $this->assertEquals($yo->sum([1, 2, 3, 4, 5]), 15);
    }

    public function testMultiply()
    {
        $yo = new Yo();
        $this->assertEquals($yo->multiply(3, 5), 15);
    }

    public function testDivide()
    {
        $yo = new Yo();
        $this->assertEquals($yo->divide(10, 2), 5);
    }

    public function testMean()
    {
        $yo = new Yo();
        $this->assertEquals($yo->mean([4, 2, 8, 6]), 5);
    }

    public function testMax()
    {
        $yo = new Yo();
        $this->assertEquals($yo->max([4, 2, 8, 6]), 8);
    }

    public function testMin()
    {
        $yo = new Yo();
        $this->assertEquals($yo->min([4, 2, 8, 6]), 2);
    }

    public function testIsFinite()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isFinite(1), true);
        $this->assertEquals($yo->isFinite(INF), false);
    }

    public function testIsPositive()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isPositive(1), true);
        $this->assertEquals($yo->isPositive(-1), false);
        $this->assertEquals($yo->isPositive('string'), false);
        $this->assertEquals($yo->isPositive([]), false);
    }

    public function testIsNegative()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isNegative(-1), true);
        $this->assertEquals($yo->isNegative(1), false);
        $this->assertEquals($yo->isNegative('string'), false);
        $this->assertEquals($yo->isNegative([]), false);
    }

    public function testIsNumber()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isNumber(1), true);
        $this->assertEquals($yo->isNumber(INF), true);
        $this->assertEquals($yo->isNumber('string'), false);
        $this->assertEquals($yo->isNumber([]), false);
    }

    public function testFactorial()
    {
        $yo = new Yo();
        $this->assertEquals($yo->factorial(0), 1);
        $this->assertEquals($yo->factorial(1), 1);
        $this->assertEquals($yo->factorial(2), 2);
        $this->assertEquals($yo->factorial(3), 6);
        $this->assertEquals($yo->factorial(4), 24);
        $this->assertEquals($yo->factorial(5), 120);
        $this->assertEquals($yo->factorial(6), 720);
        $this->assertEquals($yo->factorial(7), 5040);
        $this->assertEquals($yo->factorial(8), 40320);
        $this->assertEquals($yo->factorial(9), 362880);
        $this->assertEquals($yo->factorial(10), 3628800);
        $this->assertEquals($yo->factorial(11), 39916800);
        $this->assertEquals($yo->factorial(12), 479001600);
        $this->assertEquals($yo->factorial(13), 6227020800);
        $this->assertEquals($yo->factorial(14), 87178291200);
        $this->assertEquals($yo->factorial(15), 1307674368000);
        $this->assertEquals($yo->factorial(16), 20922789888000);
        $this->assertEquals($yo->factorial(17), 355687428096000);
        $this->assertEquals($yo->factorial(18), 6402373705728000);
        $this->assertEquals($yo->factorial(19), 121645100408832000);
        $this->assertEquals($yo->factorial(20), 2432902008176640000);
    }
}
