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

    public function testTimesCallback()
    {
        $yo = new Yo();
        $this->assertEquals($yo->times(3, [$yo, 'always']), [true, true, true, true]);
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
        $data = $yo->reduceRight([16, 23, 42], function ($initial, $i) {
            array_push($initial, $i . '-hello');
            return $initial;
        }, []);
        $this->assertEquals($data, ['42-hello', '23-hello', '16-hello']);
    }

    public function testReduceRight()
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

    public function testToArray()
    {
        $yo = new Yo();
        $this->assertEquals($yo->toArray('a', 'b', 'c', 'd'), ['a', 'b', 'c', 'd']);
    }

    public function testSlice()
    {
        $value = [1, 2, 3];
        $yo = new Yo();
        $this->assertEquals($yo->slice($value, 1, 3), [2, 3]);
        $this->assertNotEquals($value, [2, 3]);
        $this->assertEquals($yo->slice([1, 2, 3], 0), [1, 2, 3]);
        $this->assertEquals($yo->slice([1, 2, 3], 1), [2, 3]);
        $this->assertEquals($yo->slice([1, 2, 3], 2), [3]);
        $this->assertEquals($yo->slice([1, 2, 3], 3), []);
        $this->assertEquals($yo->slice([1, 2, 3], 0, 0), []);
        $this->assertEquals($yo->slice([1, 2, 3], 0, 1), [1]);
        $this->assertEquals($yo->slice([1, 2, 3], 0, 2), [1, 2]);
        $this->assertEquals($yo->slice([1, 2, 3], 1, 3), [2, 3]);
    }

    public function testDrop()
    {
        $value = [1, 2, 3];
        $yo = new Yo();
        $this->assertEquals($yo->drop($value, 1), [2, 3]);
        $this->assertNotEquals($value, [2, 3]);
        $this->assertEquals($yo->drop([1, 2, 3], 0), [1, 2, 3]);
        $this->assertEquals($yo->drop([1, 2, 3], 1), [2, 3]);
        $this->assertEquals($yo->drop([1, 2, 3], 2), [3]);
        $this->assertEquals($yo->drop([1, 2, 3], 3), []);
    }

    public function testDropRight()
    {
        $value = [1, 2, 3];
        $yo = new Yo();
        $this->assertEquals($yo->dropRight($value, 1), [1, 2]);
        $this->assertNotEquals($value, [1, 2]);
        $this->assertEquals($yo->dropRight([1, 2, 3], 0), [1, 2, 3]);
        $this->assertEquals($yo->dropRight([1, 2, 3], 1), [1, 2]);
        $this->assertEquals($yo->dropRight([1, 2, 3], 2), [1]);
        $this->assertEquals($yo->dropRight([1, 2, 3], 3), []);
    }

    public function testFind()
    {
        $value = [1, 2, 3];
        $yo = new Yo();
        $this->assertEquals($yo->find([1, 2, 3, 4], 3), 3);
    }

    public function testFindBinarySearch()
    {
        $value = [1, 2, 3];
        $yo = new Yo();
        $this->assertEquals($yo->find([1, 2, 3, 4], 3, true), 3);
    }

    public function testWhere()
    {
        $value = [['a' => 1], ['b' => 2], ['a' => 1]];
        $yo = new Yo();
        $this->assertEquals($yo->where($value, ['a' => 1]), [['a' => 1], ['a' => 1]]);
    }

    public function testChunk()
    {
        $yo = new Yo();

        $value = $yo->chunk([1, 2, 3, 4, 5, 6, 7, 8], 2);
        $this->assertEquals($value, [[1, 2], [3, 4], [5, 6], [7, 8]]);

        $value2 = $yo->chunk([1, 2, 3, 4, 5, 6, 7, 8], 3);
        $this->assertEquals($value2, [[1, 2, 3], [4, 5, 6], [7, 8]]);

        $value3 = $yo->chunk([1, 2, 3, 4, 5, 6, 7, 8, 9], 3);
        $this->assertEquals($value3, [[1, 2, 3], [4, 5, 6], [7, 8, 9]]);

        $value4 = $yo->chunk([1, 2, 3, 4, 5, 6, 7, 8, 9, 10], 3);
        $this->assertEquals($value4, [[1, 2, 3], [4, 5, 6], [7, 8, 9], [10]]);
    }

    public function testMerge()
    {
        $yo = new Yo();
        $this->assertEquals($yo->merge([1, 2, 3], [4, 5]), [1, 2, 3, 4, 5]);
        $this->assertEquals($yo->merge([1, 2, 3], [4, 5], [6]), [1, 2, 3, 4, 5, 6]);
        $this->assertEquals($yo->merge([1, 2, 3], [4, 5], [6], [7, 8]), [1, 2, 3, 4, 5, 6, 7, 8]);
    }

    public function testEach()
    {
        $val = 0;
        $yo = new Yo();
        $yo->each([1, 2], function () use (&$val) {
            $val++;
        });
        $this->assertEquals($val, 2);
    }

    public function testExtend()
    {
        $yo = new Yo();
        $this->assertEquals($yo->extend(['a' => 1], ['b' => 2]), ['a' => 1, 'b' => 2]);
        $this->assertEquals($yo->extend(['a' => 1], ['a' => 2]), ['a' => 2]);
    }

    public function testFindDuplicates()
    {
        $yo = new Yo();
        $this->assertEquals($yo->findDuplicates([2, 3, 4, 3, 10, 10]), [3, 10]);
    }

    public function testSkipDuplicates()
    {
        $yo = new Yo();
        $this->assertEquals($yo->skipDuplicates([2, 3, 4, 3, 10, 10]), [2, 3, 4, 10]);
    }

    public function testDuplicate()
    {
        $yo = new Yo();
        $this->assertEquals($yo->duplicate([1, 2, 3, 4, 5]), [1, 2, 3, 4, 5, 1, 2, 3, 4, 5]);
    }

    public function testInitial()
    {
        $yo = new Yo();
        $this->assertEquals($yo->initial([1, 2, 3, 4]), [1, 2, 3]);
    }

    public function testHead()
    {
        $yo = new Yo();
        $this->assertEquals($yo->head([1, 2, 3, 4]), 1);
    }

    public function testTail()
    {
        $yo = new Yo();
        $this->assertEquals($yo->tail([1, 2, 3, 4]), [2, 3, 4]);
    }

    public function testIndexOf()
    {
        $yo = new Yo();
        $this->assertEquals($yo->indexOf([1, 2, 3], 3), 2);
        $this->assertEquals($yo->indexOf([1, 2, 3], 4), false);
        $this->assertEquals($yo->indexOf([1, 2, 3], 2, 1), 0);
        $this->assertEquals($yo->indexOf([1, 2, 3], 3, 1), 1);
    }

    public function testLastOfTheLastOfTheLast()
    {
        $yo = new Yo();
        $value = $yo->lastOfTheLastOfTheLast([1, 2, [11, 22], [111, [1111, 2222]]]);
        $this->assertEquals($value, 2222);
    }

    public function testFindLargestSubArrayBySum()
    {
        $yo = new Yo();
        $value = $yo->findLargestSubArrayBySum([[1, 2, 3, 4, 5000], [1, 2], [2000, 2]]);
        $this->assertEquals($value, ['index' => 0, 'item' => [1, 2, 3, 4, 5000], 'value' => 5010]);
    }

    public function testFindPairsBySum()
    {
        $yo = new Yo();
        $value = $yo->findPairsBySum([10, 5, 6, 7, 2, 8, 1, 9, 14], 15);
        $this->assertEquals($value, [[10, 5], [6, 9], [7, 8], [1, 14]]);
    }

    public function testPick()
    {
        $yo = new Yo();
        $this->assertEquals($yo->pick([['a' => 1], ['b' => 2]], ['a' => 1]), [['a' => 1]]);
        $this->assertEquals($yo->pick([['a' => 1], ['b' => 2]], ['a' => 2]), []);
        $this->assertEquals($yo->pick([['a' => 1], ['b' => 2], ['b' => 2, 'c' => 3]], ['b' => 2]), [['b' => 2], ['b' => 2, 'c' => 3]]);
    }

    public function testMatches()
    {
        $yo = new Yo();

        $value = $yo->matches(['a' => 1, 'b' => 2, 'c' => 3], ['c' => 3]);
        $noValue = $yo->matches(['a' => 1, 'b' => 2, 'c' => 3], ['d' => 4]);

        $this->assertEquals($value, true);
        $this->assertEquals($noValue, false);
    }

    public function testFindKey()
    {
        $yo = new Yo();

        $value = $yo->findKey(['a' => 1, 'b' => 2, 'c' => 3], 'a');
        $noValue = $yo->findKey(['a' => 1, 'b' => 2, 'c' => 3], 'd');

        $this->assertEquals($value, 1);
        $this->assertEquals($noValue, false);
    }

    public function testGet()
    {
        $value = ['a' => ['b' => ['c' => 1]]];
        $yo = new Yo();
        $this->assertEquals($yo->get($value, '.a'), ['b' => ['c' => 1]]);
        $this->assertEquals($yo->get($value, '.a.b'), ['c' => 1]);
        $this->assertEquals($yo->get($value, '.a.b.c'), 1);
    }

    public function testFill()
    {
        $yo = new Yo();
        $this->assertEquals($yo->fill([1, 2, 3], 'a'), ['a', 'a', 'a']);
    }
}
