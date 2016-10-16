<?php
namespace Yo;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoFunctions extends TestCase
{
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

    public function testMethodCount()
    {
        $yo = new Yo();
        $this->assertEquals($yo->methodCount(), 45);
    }
}
