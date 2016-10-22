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

    public function testReject()
    {
        $callback = function ($i) {
            return $i === 1;
        };

        $yo = new Yo();
        $data = $yo->chain([1, 2, 1, 2])->reject($callback)->value();
        $this->assertEquals($data, [2, 2]);
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

    public function testMapAndReject()
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
          ->reject($callback)
          ->value();

        $this->assertEquals($data, [2, 3, 101]);
    }

    public function testJson()
    {
        $yo = new Yo();
        $data = $yo
          ->lazyChain([1, 2, 0, 0, 100])
          ->map([$yo, 'addSelf'])
          ->toJSON();

        $this->assertEquals($data, '[2,4,0,0,200]');
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

    public function testFind()
    {
        $yo = new Yo();
        $data = $yo
          ->chain([4, 8, 15, 16, 23, 42])
          ->find(function ($i) {
            return $i === 4;
          })
          ->value();
        $this->assertEquals($data, 4);
    }

    public function testFindKey()
    {
        $yo = new Yo();
        $data = $yo
          ->chain(['a' => 1, 'b' => 2])
          ->findKey('a')
          ->value();
        $this->assertEquals($data, 1);
    }

    public function testPick()
    {
        $yo = new Yo();
        $data = $yo
          ->chain(['a' => 1, 'b' => 2])
          ->findKey('a')
          ->value();
        $this->assertEquals($data, 1);
    }

    public function testDrop()
    {
        $yo = new Yo();
        $data = $yo
          ->chain([1, 2, 3, 4])
          ->drop(2)
          ->value();
        $this->assertEquals($data, [3, 4]);
    }

    public function testDropRight()
    {
        $yo = new Yo();
        $data = $yo
          ->chain([1, 2, 3, 4])
          ->dropRight(2)
          ->value();
        $this->assertEquals($data, [1, 2]);
    }

    public function testFlatten()
    {
        $yo = new Yo();
        $data = $yo
          ->chain([[1], [2], [3, 4]])
          ->flatten()
          ->value();
        $this->assertEquals($data, [1, 2, 3, 4]);
    }

    public function testFirst()
    {
        $yo = new Yo();
        $data = $yo
          ->chain([1, 2, 3, 4])
          ->first()
          ->value();
        $this->assertEquals($data, 1);
    }

    public function testRest()
    {
        $yo = new Yo();
        $data = $yo
          ->chain([1, 2, 3, 4])
          ->rest()
          ->value();
        $this->assertEquals($data, [2, 3, 4]);
    }

    public function testReverse()
    {
        $yo = new Yo();
        $data = $yo
          ->chain([1, 2, 3, 4])
          ->reverse()
          ->value();
        $this->assertEquals($data, [4, 3, 2, 1]);
    }
}
