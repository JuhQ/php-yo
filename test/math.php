<?php
namespace Yo;

include_once('./src/yo.php');

use PHPUnit\Framework\TestCase;

class YoMath extends TestCase
{
    public function testAdd()
    {
        $yo = new Yo();
        $this->assertEquals($yo->add(1, 2), 3);
    }

    public function testSelfAdd()
    {
        $yo = new Yo();
        $this->assertEquals($yo->addSelf(1, 1), 2);
    }

    public function testSubtract()
    {
        $yo = new Yo();
        $this->assertEquals($yo->subtract(1, 2), -1);
    }

    public function testSum()
    {
        $yo = new Yo();
        $this->assertEquals($yo->sum([1, 2, 3, 4, 5]), 15);
    }

    public function testMultiply()
    {
        $yo = new Yo();
        $this->assertEquals($yo->multiply(3, 5), 15);
    }

    public function testDivide()
    {
        $yo = new Yo();
        $this->assertEquals($yo->divide(10, 2), 5);
    }

    public function testMean()
    {
        $yo = new Yo();
        $this->assertEquals($yo->mean([4, 2, 8, 6]), 5);
    }

    public function testMax()
    {
        $yo = new Yo();
        $this->assertEquals($yo->max([4, 2, 8, 6]), 8);
    }

    public function testMin()
    {
        $yo = new Yo();
        $this->assertEquals($yo->min([4, 2, 8, 6]), 2);
    }

    public function testIsFinite()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isFinite(1), true);
        $this->assertEquals($yo->isFinite(INF), false);
    }

    public function testIsPositive()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isPositive(1), true);
        $this->assertEquals($yo->isPositive(-1), false);
        $this->assertEquals($yo->isPositive('string'), false);
        $this->assertEquals($yo->isPositive([]), false);
    }

    public function testIsNegative()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isNegative(-1), true);
        $this->assertEquals($yo->isNegative(1), false);
        $this->assertEquals($yo->isNegative('string'), false);
        $this->assertEquals($yo->isNegative([]), false);
    }

    public function testIsNumber()
    {
        $yo = new Yo();
        $this->assertEquals($yo->isNumber(1), true);
        $this->assertEquals($yo->isNumber(INF), true);
        $this->assertEquals($yo->isNumber('string'), false);
        $this->assertEquals($yo->isNumber([]), false);
    }

    public function testMissingNumber()
    {
        $yo = new Yo();
        $this->assertEquals($yo->missingNumber([5, 2, 6, 1, 3]), 4);
    }

    public function testFindLargestSum()
    {
        $yo = new Yo();
        $this->assertEquals($yo->findLargestSum([1, 2, 3, 4, 5]), 9);
        $this->assertEquals($yo->findLargestSum([1, 2, 3, 4, 5, 5]), 10);
        $this->assertEquals($yo->findLargestSum([1, 2, 3, 4, 5, 6]), 11);
    }

    public function testGreatestCommonDivisor()
    {
        $yo = new Yo();
        $this->assertEquals($yo->greatestCommonDivisor(14, 21), 7);
        $this->assertEquals($yo->greatestCommonDivisor(69, 169), 1);
    }

    public function testFibonacci()
    {
        $yo = new Yo();
        $this->assertEquals($yo->fibonacci(0), 0);
        $this->assertEquals($yo->fibonacci(1), 1);
        $this->assertEquals($yo->fibonacci(2), 1);
        $this->assertEquals($yo->fibonacci(3), 2);
        $this->assertEquals($yo->fibonacci(4), 3);
        $this->assertEquals($yo->fibonacci(5), 5);
        $this->assertEquals($yo->fibonacci(6), 8);
        $this->assertEquals($yo->fibonacci(7), 13);
        $this->assertEquals($yo->fibonacci(8), 21);
        $this->assertEquals($yo->fibonacci(9), 34);
        $this->assertEquals($yo->fibonacci(10), 55);
        $this->assertEquals($yo->fibonacci(11), 89);
        $this->assertEquals($yo->fibonacci(12), 144);
        $this->assertEquals($yo->fibonacci(13), 233);
        $this->assertEquals($yo->fibonacci(14), 377);
        $this->assertEquals($yo->fibonacci(15), 610);
        $this->assertEquals($yo->fibonacci(16), 987);
        $this->assertEquals($yo->fibonacci(17), 1597);
        $this->assertEquals($yo->fibonacci(18), 2584);
        $this->assertEquals($yo->fibonacci(19), 4181);
        $this->assertEquals($yo->fibonacci(20), 6765);
    }

    public function testFactorial()
    {
        $yo = new Yo();
        $this->assertEquals($yo->factorial(0), 1);
        $this->assertEquals($yo->factorial(1), 1);
        $this->assertEquals($yo->factorial(2), 2);
        $this->assertEquals($yo->factorial(3), 6);
        $this->assertEquals($yo->factorial(4), 24);
        $this->assertEquals($yo->factorial(5), 120);
        $this->assertEquals($yo->factorial(6), 720);
        $this->assertEquals($yo->factorial(7), 5040);
        $this->assertEquals($yo->factorial(8), 40320);
        $this->assertEquals($yo->factorial(9), 362880);
        $this->assertEquals($yo->factorial(10), 3628800);
        $this->assertEquals($yo->factorial(11), 39916800);
        $this->assertEquals($yo->factorial(12), 479001600);
        $this->assertEquals($yo->factorial(13), 6227020800);
        $this->assertEquals($yo->factorial(14), 87178291200);
        $this->assertEquals($yo->factorial(15), 1307674368000);
        $this->assertEquals($yo->factorial(16), 20922789888000);
        $this->assertEquals($yo->factorial(17), 355687428096000);
        $this->assertEquals($yo->factorial(18), 6402373705728000);
        $this->assertEquals($yo->factorial(19), 121645100408832000);
        $this->assertEquals($yo->factorial(20), 2432902008176640000);
    }

    public function testMathChain()
    {
        $yo = new Yo();

        $result = $yo->mathChain(100)
            ->add(1)
            ->addSelf()
            ->subtract(50)
            ->divide(2)
            ->multiply(5)
            ->sum([50, 100, 200, 300])
            ->mean([50, 100, 200, 300])
            ->plug(function ($val) {
                return $val + 50;
            })
            ->value();

        $this->assertEquals($result, 386);
    }

    public function testIsPrime()
    {
        $primes = [
            2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67,
            71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113, 127, 131, 137, 139, 149,
            151, 157, 163, 167, 173, 179, 181, 191, 193, 197, 199, 211, 223, 227, 229,
            233, 239, 241, 251, 257, 263, 269, 271, 277, 281, 283, 293, 307, 311,
            313, 317, 331, 337, 347, 349, 353, 359, 367, 373, 379, 383, 389, 397,
            401, 409, 419, 421, 431, 433, 439, 443, 449, 457, 461, 463, 467, 479,
            487, 491, 499, 503, 509, 521, 523, 541, 547, 557, 563, 569, 571, 577,
            587, 593, 599, 601, 607, 613, 617, 619, 631, 641, 643, 647, 653, 659,
            661, 673, 677, 683, 691, 701, 709, 719, 727, 733, 739, 743, 751, 757,
            761, 769, 773, 787, 797, 809, 811, 821, 823, 827, 829, 839, 853, 857,
            859, 863, 877, 881, 883, 887, 907, 911, 919, 929, 937, 941, 947, 953,
            967, 971, 977, 983, 991, 997
        ];
        $nonPrimes = [90, 91, 92, 93, 94, 95, 96];

        $yo = new Yo();

        foreach ($primes as $prime) {
            $this->assertEquals($yo->isPrime($prime), true);
        }

        foreach ($nonPrimes as $prime) {
            $this->assertEquals($yo->isPrime($prime), false);
        }
    }

    public function testPrimeNumbers()
    {
        $primes = [
            2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67,
            71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113, 127, 131, 137, 139, 149,
            151, 157, 163, 167, 173, 179, 181, 191, 193, 197, 199, 211, 223, 227, 229,
            233, 239, 241, 251, 257, 263, 269, 271, 277, 281, 283, 293, 307, 311,
            313, 317, 331, 337, 347, 349, 353, 359, 367, 373, 379, 383, 389, 397,
            401, 409, 419, 421, 431, 433, 439, 443, 449, 457, 461, 463, 467, 479,
            487, 491, 499, 503, 509, 521, 523, 541, 547, 557, 563, 569, 571, 577,
            587, 593, 599, 601, 607, 613, 617, 619, 631, 641, 643, 647, 653, 659,
            661, 673, 677, 683, 691, 701, 709, 719, 727, 733, 739, 743, 751, 757,
            761, 769, 773, 787, 797, 809, 811, 821, 823, 827, 829, 839, 853, 857,
            859, 863, 877, 881, 883, 887, 907, 911, 919, 929, 937, 941, 947, 953,
            967, 971, 977, 983, 991, 997
        ];
        $yo = new Yo();
        $this->assertEquals($yo->primeNumbers(1000), $primes);
    }
}
