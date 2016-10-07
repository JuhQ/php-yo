<?php
namespace Yo;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoStrings extends TestCase
{
    public function testIsString()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isString('string'), true);
        $this->assertEquals($yo->isString(1), false);
    }

    public function testLowercase()
    {
        $yo = new Yo();
        $this->assertEquals($yo->lowercase('String'), 'string');
        $this->assertEquals($yo->lowercase('string'), 'string');
        $this->assertEquals($yo->lowercase('STRING'), 'string');
        $this->assertEquals($yo->lowercase('sTrInG'), 'string');
    }

    public function testUppercase()
    {
        $yo = new Yo();
        $this->assertEquals($yo->uppercase('String'), 'STRING');
        $this->assertEquals($yo->uppercase('string'), 'STRING');
        $this->assertEquals($yo->uppercase('STRING'), 'STRING');
        $this->assertEquals($yo->uppercase('sTrInG'), 'STRING');
    }

    public function testCapitalize()
    {
        $yo = new Yo();

        $this->assertEquals($yo->capitalize('String'), 'String');
        $this->assertEquals($yo->capitalize('string'), 'String');
        $this->assertEquals($yo->capitalize('STRING'), 'String');
        $this->assertEquals($yo->capitalize('sTrInG'), 'String');
    }

    public function testIsPalindrome()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isPalindrome('otto'), true);
        $this->assertEquals($yo->isPalindrome('race car'), true);
        $this->assertEquals($yo->isPalindrome('             '), true);
        $this->assertEquals($yo->isPalindrome('0_0 (: /-\\ :) 0-0'), true);
        $this->assertEquals($yo->isPalindrome('not palindrome'), false);
    }

    public function testKebabCase()
    {
        $yo = new Yo();
        $this->assertEquals($yo->kebabCase('kebab case'), 'kebab-case');
        $this->assertEquals($yo->kebabCase('Kebab Case'), 'kebab-case');
        $this->assertEquals($yo->kebabCase('  Kebab Case  '), 'kebab-case');
    }
}
