<?php
namespace Yo;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoMap extends TestCase
{
    public function testMapValues()
    {
        $add = function ($val) {
            return $val + 1;
        };

        $yo = new Yo();
        $this->assertEquals($yo->map([1, 2], $add), [2, 3]);
    }

    public function testMapString()
    {
        $yo = new Yo();
        $this->assertEquals($yo->map('string'), ['string']);
    }
}
