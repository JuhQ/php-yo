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

    public function testReject()
    {
        $callback = function ($i) {
            return $i === 1;
        };

        $yo = new Yo();
        $this->assertEquals($yo->reject([1, 2, 1, 2, 3], $callback), [2, 2, 3]);
    }

    public function testReduce()
    {
        $yo = new Yo();
        $data = $yo->reduce([4, 8, 15, 16, 23, 42], [$yo, 'add'], 0);
        $this->assertEquals($data, 108);
    }

    public function testCompact()
    {
        $yo = new Yo();
        $data = $yo->compact([false, 0, null, '', 1, true]);
        $this->assertEquals($data, [1, true]);
    }

    public function testEvery()
    {
        $yo = new Yo();
        $this->assertEquals($yo->every([1, 2, true, 'string']), true);
        $this->assertEquals($yo->every([1, 2, true, 'string'], [$yo, 'isTruthy']), true);
        $this->assertEquals($yo->every([1, 2, true, 'string', false]), false);
        $this->assertEquals($yo->every([1, 2, true, 'string', false], [$yo, 'isTruthy']), false);
        $this->assertEquals($yo->every([1, 2, true, 'string', false], [$yo, 'isFalsey']), false);
    }

    public function testSome()
    {
        $yo = new Yo();
        $this->assertEquals($yo->some([0, false, null]), false);
        $this->assertEquals($yo->some([0, false, null], [$yo, 'isTruthy']), false);
        $this->assertEquals($yo->some([0, false, null, true]), true);
        $this->assertEquals($yo->some([0, false, null, true], [$yo, 'isTruthy']), true);
        $this->assertEquals($yo->some([1, 2, true, 'string']), true);
        $this->assertEquals($yo->some([1, 2, true, 'string'], [$yo, 'isTruthy']), true);
        $this->assertEquals($yo->some([1, 2, true, 'string', false]), true);
        $this->assertEquals($yo->some([1, 2, true, 'string', false], [$yo, 'isTruthy']), true);
    }

    public function testNone()
    {
        $yo = new Yo();
        $this->assertEquals($yo->none([0, false, null]), true);
        $this->assertEquals($yo->none([0, false, null, true], [$yo, 'never']), true);
        $this->assertEquals($yo->none([0, false, null, true, 'string']), false);
        $this->assertEquals($yo->none([0, false, null], [$yo, 'isFalsey']), false);
        $this->assertEquals($yo->none([0, false, null], [$yo, 'isTruthy']), true);
    }

    public function testBinarySearch()
    {
        $data = [1, 2, 3, 4, 3, 4, 200, 300];

        $yo = new Yo();
        $result = $yo->binarySearch($data, 200);

        $this->assertEquals($yo->binarySearch([1, 2, 3, 4], 3), 2);
        $this->assertEquals($yo->binarySearch($data, 200), 6);
        $this->assertEquals($data[$result], 200);
    }

    public function testSample()
    {
        $yo = new Yo();
        $this->assertContains($yo->sample([0, 1, 2]), [0, 1, 2]);
    }
}
