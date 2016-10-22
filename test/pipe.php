<?php
namespace Yo;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoPipe extends TestCase
{
    public function testPipeSimple()
    {
        $add5 = function ($value) {
            return $value + 5;
        };

        $yo = new Yo();
        $this->assertEquals($yo->pipe($add5)(5), 10);
    }

    public function testPipeMultipleFunc()
    {
        $add5 = function ($value) {
            return $value + 5;
        };

        $add5With5args = function ($a, $b, $c, $d, $e) {
            return 1 + $a + $b + $c + $d + $e;
        };

        $multiplyBy10 = function ($value) {
            return $value * 10;
        };

        $yo = new Yo();
        $this->assertEquals($yo->pipe($add5, $multiplyBy10)(5), 100);
        $this->assertEquals($yo->pipe($add5With5args, $add5, $multiplyBy10)(1, 1, 1, 1, 1), 110);
    }

    public function testPipeStringToMap()
    {
        $addWorld = function ($value) {
            return $value . ' world';
        };

        $createArray = function ($value) {
            return [$value];
        };

        $yo = new Yo();
        $this->assertEquals($yo->pipe($addWorld, $createArray)('hello'), ['hello world']);
    }

    public function testPipeRightStringToMap()
    {
        $yo = new Yo();
        $addWorld = function ($value) use ($yo) {
            return $yo->first($value) . ' world';
        };

        $createArray = function ($value) {
            return [$value];
        };

        $this->assertEquals($yo->pipeRight($addWorld, $createArray)('hello'), 'hello world');
    }
}
