<?php
namespace Yo;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoChain extends TestCase
{
    public function testMap()
    {
        $add = function ($val) {
            return $val + 1;
        };

        $yo = new Yo();
        $data = $yo->chain([1, 2])->map($add)->value();
        $this->assertEquals($data, [2, 3]);
    }

    public function testFilter()
    {
        $callback = function ($i) {
            return $i === 1;
        };

        $yo = new Yo();
        $data = $yo->chain([1, 2, 1, 2])->filter($callback)->value();
        $this->assertEquals($data, [1, 1]);
    }

    public function testMapAndFilter()
    {
        $add = function ($val) {
            return $val + 1;
        };
        $callback = function ($i) {
            return $i === 1;
        };

        $yo = new Yo();
        $data = $yo
          ->chain([1, 2, 0, 0, 100])
          ->map($add)
          ->filter($callback)
          ->value();

        $this->assertEquals($data, [1, 1]);
    }

    public function testReduce()
    {
        $yo = new Yo();
        $data = $yo
          ->chain([4, 8, 15, 16, 23, 42])
          ->reduce([$yo, 'add'], 0)
          ->value();
        $this->assertEquals($data, 108);
    }

}
