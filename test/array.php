<?php
namespace Yo;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoArray extends TestCase
{
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
