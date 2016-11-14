<?php
namespace Yo;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoIs extends TestCase
{
    public function testIsFloat()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isFloat(1.0), true);
        $this->assertEquals($yo->isFloat(1.5), true);
        $this->assertEquals($yo->isFloat(1), false);
    }

    public function testIsBoolean()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isBoolean(true), true);
        $this->assertEquals($yo->isBoolean(false), true);
        $this->assertEquals($yo->isBoolean($yo->always()), true);
        $this->assertEquals($yo->isBoolean($yo->never()), true);
        $this->assertEquals($yo->isBoolean(null), false);
        $this->assertEquals($yo->isBoolean('string'), false);
        $this->assertEquals($yo->isBoolean(0), false);
        $this->assertEquals($yo->isBoolean(1), false);
        $this->assertEquals($yo->isBoolean(''), false);
    }

    public function testIsNull()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isNull(null), true);
        $this->assertEquals($yo->isNull(true), false);
        $this->assertEquals($yo->isNull($yo->always()), false);
        $this->assertEquals($yo->isNull('string'), false);
        $this->assertEquals($yo->isNull(false), false);
        $this->assertEquals($yo->isNull(0), false);
        $this->assertEquals($yo->isNull(1), false);
        $this->assertEquals($yo->isNull(''), false);
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
        $this->assertEquals($yo->isFunction(''), false);
        $this->assertEquals($yo->isFunction([]), false);
        $this->assertEquals($yo->isFunction(1), false);
        $this->assertEquals($yo->isFunction(null), false);
        $this->assertEquals($yo->isFunction(true), false);
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

    public function testIsEven()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isEven(1), false);
        $this->assertEquals($yo->isEven(2), true);
    }

    public function testIsOdd()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isOdd(1), true);
        $this->assertEquals($yo->isOdd(2), false);
    }
}
