<?php
namespace Yo;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoArray extends TestCase
{
    public function testIsArray()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isArray([1, 2]), true);
        $this->assertEquals($yo->isArray('string'), false);
    }

    public function testIsEmpty()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isEmpty([]), true);
        $this->assertEquals($yo->isEmpty([1, 2]), false);
    }

    public function testFlatten()
    {
        $yo = new Yo();
        $this->assertEquals($yo->flatten([1, 2, [3, 4]]), [1, 2, 3, 4]);
        $this->assertEquals($yo->flatten([1, 2, [3, 4, [5, 6]]]), [1, 2, 3, 4, 5, 6]);
    }

    public function testFirst()
    {
        $yo = new Yo();
        $this->assertEquals($yo->first([1, 2]), 1);
    }

    public function testLast()
    {
        $yo = new Yo();
        $this->assertEquals($yo->last([1, 2]), 2);
    }

    public function testRest()
    {
        $yo = new Yo();
        $this->assertEquals($yo->rest([1, 2, 3]), [2, 3]);
    }
}
