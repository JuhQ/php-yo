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

    public function testRange()
    {
        $yo = new Yo();
        $this->assertEquals($yo->range(4), [0, 1, 2, 3, 4]);
    }
    public function testTimes()
    {
        $yo = new Yo();
        $this->assertEquals($yo->times(4), [0, 1, 2, 3, 4]);
        $this->assertEquals($yo->times(4), $yo->range(4));
    }

    public function testFilter()
    {
        $callback = function ($i) {
            return $i === 1;
        };

        $yo = new Yo();
        $this->assertEquals($yo->filter([1, 2, 1, 2, 3], $callback), [1, 1]);
    }

    public function testReduce()
    {
        $yo = new Yo();
        $data = $yo->reduce([4, 8, 15, 16, 23, 42], [$yo, 'add'], 0);
        $this->assertEquals($data, 108);
    }
}
