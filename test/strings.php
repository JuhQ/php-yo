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

    public function testSnakeCase()
    {
        $yo = new Yo();
        $this->assertEquals($yo->snakeCase('snake case'), 'snake_case');
        $this->assertEquals($yo->snakeCase('Snake Case'), 'snake_case');
        $this->assertEquals($yo->snakeCase('  Snake Case  '), 'snake_case');
        $this->assertEquals($yo->snakeCase('-Snake-Case-'), 'snake_case');
        $this->assertEquals($yo->snakeCase('_Snake_Case_'), 'snake_case');
        $this->assertEquals($yo->snakeCase('_Snake-Case_'), 'snake_case');
        $this->assertEquals($yo->snakeCase('_Snake Case_'), 'snake_case');
        $this->assertEquals($yo->snakeCase('___Snake_Case___'), 'snake_case');
        $this->assertEquals($yo->snakeCase('___Snake___Case___'), 'snake_case');
    }

    public function testKebabCase()
    {
        $yo = new Yo();
        $this->assertEquals($yo->kebabCase('kebab case'), 'kebab-case');
        $this->assertEquals($yo->kebabCase('Kebab Case'), 'kebab-case');
        $this->assertEquals($yo->kebabCase('  Kebab Case  '), 'kebab-case');
        $this->assertEquals($yo->kebabCase('-Kebab-Case-'), 'kebab-case');
        $this->assertEquals($yo->kebabCase('_Kebab_Case_'), 'kebab-case');
        $this->assertEquals($yo->kebabCase('_Kebab-Case_'), 'kebab-case');
        $this->assertEquals($yo->kebabCase('_Kebab Case_'), 'kebab-case');
        $this->assertEquals($yo->kebabCase('___Kebab_Case___'), 'kebab-case');
        $this->assertEquals($yo->kebabCase('___Kebab___Case___'), 'kebab-case');
    }

    public function testCamelCase()
    {
        $yo = new Yo();
        $this->assertEquals($yo->camelCase('camel case'), 'camelCase');
        $this->assertEquals($yo->camelCase('Camel Case'), 'camelCase');
        $this->assertEquals($yo->camelCase('  Camel Case  '), 'camelCase');
        $this->assertEquals($yo->camelCase('Camel-Case'), 'camelCase');
        $this->assertEquals($yo->camelCase('Camel-Case-'), 'camelCase');
        $this->assertEquals($yo->camelCase('-Camel-Case-'), 'camelCase');
        $this->assertEquals($yo->camelCase('Camel_Case'), 'camelCase');
        $this->assertEquals($yo->camelCase('_Camel_Case_'), 'camelCase');
        $this->assertEquals($yo->camelCase('_Camel-Case_'), 'camelCase');
        $this->assertEquals($yo->camelCase('_Camel Case_'), 'camelCase');
        $this->assertEquals($yo->camelCase('____Camel_Case____'), 'camelCase');
        $this->assertEquals($yo->camelCase('____Camel___Case____'), 'camelCase');
    }

    public function testRepeat()
    {
        $yo = new Yo();
        $this->assertEquals($yo->repeat('hello', 2), 'hellohello');
        $this->assertEquals($yo->repeat('hello', 3), 'hellohellohello');
    }

    public function testIsEmpty()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isEmpty(''), true);
        $this->assertEquals($yo->isEmpty('string'), false);
    }

    public function testSplitBy()
    {
        $yo = new Yo();
        $this->assertEquals($yo->splitBy('hello world', ' '), ['hello', 'world']);
        $this->assertEquals($yo->splitBy('hello world', 'o'), ['hell', ' w', 'rld']);
    }

    public function testWords()
    {
        $yo = new Yo();
        $this->assertEquals($yo->words('hello world'), ['hello', 'world']);
    }

    public function testLetters()
    {
        $yo = new Yo();
        $this->assertEquals($yo->letters('hello world'), ['h', 'e', 'l', 'l', 'o', 'w', 'o', 'r', 'l', 'd']);
    }

    public function testWordCount()
    {
        $yo = new Yo();
        $this->assertEquals($yo->wordCount('hello world'), 2);
    }

    public function testReverseWords()
    {
        $yo = new Yo();
        $this->assertEquals($yo->reverseWords('hello world'), 'world hello');
    }

    public function testReverseWordsInPlace()
    {
        $yo = new Yo();
        $this->assertEquals($yo->reverseInPlace('hello world'), 'olleh dlrow');
    }

    public function testTrim()
    {
        $yo = new Yo();
        $this->assertEquals($yo->trim('  hello world  '), 'hello world');
    }
}
