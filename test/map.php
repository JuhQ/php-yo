<?php
namespace Yo;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoMap extends TestCase
{
    public function testMapValues()
    {
        $yo = new Yo();

        $add = function ($val) {
            return $val + 1;
        };

        $this->assertEquals($yo->map([1, 2], $add), [2, 3]);
    }
    public function testMapString()
    {
        $yo = new Yo();
        $this->assertEquals($yo->map('string'), ['string']);
    }
}
