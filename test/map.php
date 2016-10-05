<?php
namespace Test\Map;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoMap extends TestCase
{
    public function testMapSaakeli()
    {
        $yo = new Yo\Yo();

        $add = function ($val) {
            return $val + 1;
        };

        $this->assertEquals($yo->map([1, 2], $add), [2, 3]);
    }

    public function testMapAgain()
    {
        $yo = new Yo\Yo();

        $add = function ($val) {
            return $val + 1;
        };

        $this->assertEquals($yo->map([1, 2], $add), [2, 3]);
    }
}
