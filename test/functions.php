<?php
namespace Yo;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoFunctions extends TestCase
{
    public function testAlways()
    {
        $yo = new Yo();
        $this->assertEquals($yo->always(), true);
    }

    public function testNever()
    {
        $yo = new Yo();
        $this->assertEquals($yo->never(), false);
    }

    public function testIsTruthy()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isTruthy(1), true);
        $this->assertEquals($yo->isTruthy(true), true);
        $this->assertEquals($yo->isTruthy($yo->always()), true);
        $this->assertEquals($yo->isTruthy('string'), true);
        $this->assertEquals($yo->isTruthy(false), false);
        $this->assertEquals($yo->isTruthy(0), false);
        $this->assertEquals($yo->isTruthy(''), false);
        $this->assertEquals($yo->isTruthy(null), false);
    }

    public function testIsFalsey()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isFalsey(null), true);
        $this->assertEquals($yo->isFalsey(0), true);
        $this->assertEquals($yo->isFalsey(false), true);
        $this->assertEquals($yo->isFalsey($yo->never()), true);
        $this->assertEquals($yo->isFalsey(''), true);
        $this->assertEquals($yo->isFalsey(1), false);
        $this->assertEquals($yo->isFalsey(true), false);
        $this->assertEquals($yo->isFalsey($yo->always()), false);
        $this->assertEquals($yo->isFalsey('string'), false);
    }

    public function testIsFunction()
    {
        $yo = new Yo();
        $callback = function () {
            return true;
        };
        $this->assertEquals($yo->isFunction($callback), true);
    }

    public function testIsObject()
    {
        $yo = new Yo();
        $obj = new \stdClass();
        $php7Obj = new class() {
        };
        $this->assertEquals($yo->isObject($obj), true);
        $this->assertEquals($yo->isObject($php7Obj), true);
        $this->assertEquals($yo->isObject($yo), true);
        $this->assertEquals($yo->isObject(false), false);
        $this->assertEquals($yo->isObject(''), false);
        $this->assertEquals($yo->isObject([]), false);
        $this->assertEquals($yo->isObject(1), false);
    }

    public function testIsEqual()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isEqual(1, 1), true);
        $this->assertEquals($yo->isEqual(true, true), true);
        $this->assertEquals($yo->isEqual(null, null), true);
        $this->assertEquals($yo->isEqual(false, false), true);
        $this->assertEquals($yo->isEqual('string', 'string'), true);
        $this->assertEquals($yo->isEqual('1', '1'), true);
        $this->assertEquals($yo->isEqual(1, 2), false);
        $this->assertEquals($yo->isEqual(1, null), false);
        $this->assertEquals($yo->isEqual(1, ''), false);
        $this->assertEquals($yo->isEqual(1, false), false);
        $this->assertEquals($yo->isEqual(1, '1'), false);
        $this->assertEquals($yo->isEqual(null, 'null'), false);
    }

    public function testGt()
    {
        $yo = new Yo();
        $this->assertEquals($yo->gt(2, 1), true);
        $this->assertEquals($yo->gt(1, 2), false);
        $this->assertEquals($yo->gt(0, 2), false);
    }

    public function testGte()
    {
        $yo = new Yo();
        $this->assertEquals($yo->gte(2, 1), true);
        $this->assertEquals($yo->gte(2, 2), true);
        $this->assertEquals($yo->gte(1, 2), false);
    }

    public function testLt()
    {
        $yo = new Yo();
        $this->assertEquals($yo->lt(1, 2), true);
        $this->assertEquals($yo->lt(1, 1), false);
        $this->assertEquals($yo->lt(1, 0), false);
    }

    public function testLte()
    {
        $yo = new Yo();
        $this->assertEquals($yo->lte(1, 2), true);
        $this->assertEquals($yo->lte(1, 1), true);
        $this->assertEquals($yo->lte(1, 0), false);
    }

    public function testPassthru()
    {
        $yo = new Yo();
        $this->assertEquals($yo->passthru(1, 2, 3), 1);
    }

    public function testNth()
    {
        $yo = new Yo();
        $this->assertEquals($yo->nth([1, 2, 3], 1), 2);
    }

    public function testFirstArg()
    {
        $yo = new Yo();
        $this->assertEquals($yo->firstArg(1, 2, 3), 1);
    }

    public function testRestArg()
    {
        $yo = new Yo();
        $this->assertEquals($yo->restArg(1, 2, 3), [2, 3]);
    }

    public function testLastArg()
    {
        $yo = new Yo();
        $this->assertEquals($yo->lastArg(1, 2, 3), 3);
    }

    public function testReverse()
    {
        $yo = new Yo();
        $this->assertEquals($yo->reverse('string'), 'gnirts');
        $this->assertEquals($yo->reverse([1, 2, 3]), [3, 2, 1]);
    }

    public function testSize()
    {
        $yo = new Yo();
        $this->assertEquals($yo->size('the length of this string is 31'), 31);
        $this->assertEquals($yo->size([1, 2, 3, 4, 5]), 5);
    }

    public function testInRange()
    {
        $yo = new Yo();
        $this->assertEquals($yo->inRange(1, 3, 2), true);
        $this->assertEquals($yo->inRange(1, 100, 50), true);
        $this->assertEquals($yo->inRange(1, 100, 500), false);
        $this->assertEquals($yo->inRange('string', 100, 500), false);
        $this->assertEquals($yo->inRange(1, 'string', 500), false);
        $this->assertEquals($yo->inRange(1, 100, 'string'), false);
    }

    public function testFizzBuzz()
    {
        $fizzBuzzResult = [
            1, 2, 'Fizz', 4, 'Buzz', 'Fizz', 7, 8, 'Fizz', 'Buzz', 11, 'Fizz', 13, 14,
            'FizzBuzz', 16, 17, 'Fizz', 19, 'Buzz', 'Fizz', 22, 23, 'Fizz', 'Buzz',
            26, 'Fizz', 28, 29, 'FizzBuzz', 31, 32, 'Fizz', 34, 'Buzz', 'Fizz', 37,
            38, 'Fizz', 'Buzz', 41, 'Fizz', 43, 44, 'FizzBuzz', 46, 47, 'Fizz', 49,
            'Buzz', 'Fizz', 52, 53, 'Fizz', 'Buzz', 56, 'Fizz', 58, 59, 'FizzBuzz',
            61, 62, 'Fizz', 64, 'Buzz', 'Fizz', 67, 68, 'Fizz', 'Buzz', 71, 'Fizz',
            73, 74, 'FizzBuzz', 76, 77, 'Fizz', 79, 'Buzz', 'Fizz', 82, 83, 'Fizz',
            'Buzz', 86, 'Fizz', 88, 89, 'FizzBuzz', 91, 92, 'Fizz', 94, 'Buzz',
            'Fizz', 97, 98, 'Fizz', 'Buzz'
        ];

        $yo = new Yo();
        $this->assertEquals($yo->fizzbuzz(), $fizzBuzzResult);
    }

    public function testRandom()
    {
        $yo = new Yo();
        $this->assertContains($yo->random(), [0, 1]);
        $this->assertContains($yo->random(5, 10), [5, 6, 7, 8, 9, 10]);
    }

    public function testMethodCount()
    {
        $yo = new Yo();
        $this->assertEquals($yo->methodCount(), 69);
    }
}
