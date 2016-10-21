<?php
declare(strict_types=1);

namespace Yo;

include_once('chain.php');
include_once('lazy-chain.php');
include_once('math-chain.php');

class Yo
{
    public function always(): bool
    {
        return true;
    }

    public function never(): bool
    {
        return false;
    }

    public function isFalsey($val): bool
    {
        return !$val;
    }

    public function isTruthy($val): bool
    {
        return !$this->isFalsey($val);
    }

    public function compact($arr): array
    {
        return $this->filter($arr, [$this, 'isTruthy']);
    }

    public function every($arr, $callback = null): bool
    {
        $results = $this->map($arr, function ($item) use ($callback) {
            if (isset($callback) && $this->isFunction($callback)) {
                return $callback($item);
            }

            return $this->isTruthy($item);
        });

        return $this->size($this->compact($results)) === $this->size($arr);
    }

    public function some($arr, $callback = null): bool
    {
        $results = $this->map($arr, function ($item) use ($callback) {
            if (isset($callback) && $this->isFunction($callback)) {
                return $callback($item);
            }

            return $item;
        });

        return $this->size($this->compact($results)) > 0;
    }

    public function none($arr, $callback = null): bool
    {
        return $this->reduce($arr, function ($bool, $item) use ($callback) {
            if (!$bool) {
                return false;
            }

            if (isset($callback) && $this->isFunction($callback)) {
                return !$callback($item);
            }

            if ($item) {
                return false;
            }

            return $bool;
        }, true);
    }

    public function lowercase(string $str): string
    {
        return strtolower($str);
    }

    public function uppercase(string $str): string
    {
        return strtoupper($str);
    }

    public function capitalize(string $str): string
    {
        return $this->uppercase($this->first($str)) . $this->lowercase($this->rest($str));
    }

    public function snakeCase(string $str): string
    {
        $words = preg_split('/[ -_]+/', $this->lowercase(trim($str)));
        return implode('_', $this->reject($words, [$this, 'isEmpty']));
    }

    public function kebabCase(string $str): string
    {
        $words = preg_split('/[ -_]+/', $this->lowercase(trim($str)));
        return implode('-', $this->reject($words, [$this, 'isEmpty']));
    }

    public function camelCase(string $str): string
    {
        $words = preg_split('/[ -_]+/', $this->lowercase(trim($str)));
        $words = $this->reject($words, [$this, 'isEmpty']);

        $rest = implode('', $this->map($this->rest($words), [$this, 'capitalize']));

        return $this->first($words) . $rest;
    }

    public function repeat(string $str, int $n): string
    {
        return implode('', $this->map($this->times($n - 1), function () use ($str) {
            return $str;
        }));
    }

    public function isString($val): bool
    {
        return is_string($val);
    }

    public function isFunction($val): bool
    {
        return is_callable($val);
    }

    public function isArray($val): bool
    {
        return is_array($val);
    }

    public function isObject($val): bool
    {
        return is_object($val);
    }

    public function isEmpty($val): bool
    {
        return $this->size($val) === 0;
    }

    public function isFinite($n): bool
    {
        return $this->isNumber($n) && is_finite($n);
    }

    public function isPositive($n): bool
    {
        return $this->isFinite($n) && $n > 0;
    }

    public function isNegative($n): bool
    {
        return $this->isFinite($n) && $n < 0;
    }

    public function isNumber($val): bool
    {
        return is_int($val) || is_float($val);
    }

    public function isPalindrome($str): bool
    {
        if (!$this->isString($str)) {
            return false;
        }

        if ($this->size($str) <= 2) {
            return true;
        }

        $word = preg_replace('/[\W_]/', '', $this->lowercase(trim($str)));

        return $word === $this->reverse($word);
    }

    public function isEqual($a, $b): bool
    {
        return $a === $b;
    }

    public function gt(int $a, int $b): bool
    {
        return $a > $b;
    }

    public function gte(int $a, int $b): bool
    {
        return $a >= $b;
    }

    public function lt(int $a, int $b): bool
    {
        return $a < $b;
    }

    public function lte(int $a, int $b): bool
    {
        return $a <= $b;
    }

    public function size($val): int
    {
        if ($this->isString($val)) {
            return strlen($val);
        }

        return count($val);
    }

    public function random($min = 0, $max = 0): int
    {
        if (!$this->isNumber($min)) {
            $min = 0;
        }
        if (!$this->isNumber($max)) {
            $max = 1;
        }

        return mt_rand($min, $max);
    }

    public function range(int $n): array
    {
        return range(0, $n);
    }

    public function times(int $n): array
    {
        return $this->range($n);
    }

    public function inRange($min, $max, $value): bool
    {
        if (!$this->isNumber($min) || !$this->isNumber($max) || !$this->isNumber($value)) {
            return false;
        }

        return ($min <= $value) && ($value <= $max);
    }

    public function filter($arr, $callback): array
    {
        return array_values(array_filter($arr, $callback));
    }

    public function reject($arr, $callback): array
    {
        return $this->filter($arr, function ($item) use ($callback) {
            return !$callback($item);
        });
    }

    public function sample(array $arr)
    {
        return $this->first(shuffle($arr));
    }

    public function map($arr, $callback = false): array
    {
        if (!$callback) {
            if ($this->isString($arr)) {
                return [$arr];
            }
            return $arr;
        }
        return array_map($callback, $arr);
    }

    public function add($a, $b): int
    {
        return $a + $b;
    }

    public function addSelf($a): int
    {
        return $a + $a;
    }

    public function subtract($a, $b): int
    {
        return $a - $b;
    }

    public function multiply($a, $b): int
    {
        return $a * $b;
    }

    public function divide($a, $b): int
    {
        return $a / $b;
    }

    public function mean($arr): int
    {
        return $this->divide($this->sum($arr), $this->size($arr));
    }

    public function sum($arr): int
    {
        return $this->reduce($arr, [$this, 'add'], 0);
    }

    public function factorial($n): int
    {
        return $this->reduce($this->rest($this->times($n)), [$this, 'multiply'], 1);
    }

    public function reduce($arr, $callback, $initial)
    {
        return array_reduce($arr, $callback, $initial);
    }

    public function flatten($arr): array
    {
        if ($this->isEmpty($arr)) {
            return [];
        }

        return $this->reduce($arr, function ($a, $b) {
            return array_merge($a, $this->isArray($b) ? $this->flatten($b) : [$b]);
        }, []);
    }

    public function max($arr)
    {
        return max($arr);
    }

    public function min($arr)
    {
        return min($arr);
    }
    public function first($val)
    {
        return $val[0];
    }

    public function last($val)
    {
        return $val[$this->size($val) - 1];
    }

    public function rest($val)
    {
        if ($this->isString($val)) {
            return implode('', $this->rest(str_split($val)));
        }

        return array_slice($val, 1);
    }

    public function passthru()
    {
        return $this->first(func_get_args());
    }

    public function nth($arr, $n)
    {
        return $arr[$n];
    }

    public function firstArg()
    {
        return call_user_func_array([$this, 'passthru'], func_get_args());
    }

    public function restArg()
    {
        return $this->rest(func_get_args());
    }

    public function lastArg()
    {
        return $this->last(func_get_args());
    }

    public function reverse($val)
    {
        if ($this->isString($val)) {
            return implode('', $this->reverse(str_split($val)));
        }

        return array_reverse($val);
    }

    public function isPrime(int $n): bool
    {
        $divisor = 2;

        if ($n <= 1) {
            return false;
        }

        while ($n > $divisor) {
            if ($n % $divisor === 0) {
                return false;
            }

            $divisor++;
        }

        return true;
    }

    public function primeNumbers(int $n): array
    {
        return $this->filter($this->times($n), [$this, 'isPrime']);
    }

    private function doBinarySearch($start, $end, $arr, $value)
    {
        if ($start > $end) {
            return null;
        }
        if ($arr[$start] === $value) {
            return $start;
        }
        if ($arr[$end] === $value) {
            return $end;
        }

        $middle = floor(($start + $end) / 2);
        $middleValue = $arr[$middle];

        if ($middleValue === $value) {
            return $middleValue;
        } else if ($middleValue > $value) {
            return $this->doBinarySearch($start + 1, $middle, $arr, $value);
        } else if ($middleValue < $value) {
            return $this->doBinarySearch($middle, $end - 1, $arr, $value);
        }

        return null;
    }

    public function binarySearch(array $arr, int $value): int
    {
        return $this->doBinarySearch(0, $this->size($arr) - 1, $arr, $value);
    }

    public function fizzbuzz(): array
    {
        return $this
            ->chain(range(1, 100))
            ->map(function ($i) {
                $fizz = 'Fizz';
                $buzz = 'Buzz';
                $three = $i % 3 === 0;
                $five = $i % 5 === 0;

                if ($three && $five) {
                    return $fizz . $buzz;
                } else if ($three) {
                    return $fizz;
                } else if ($five) {
                    return $buzz;
                }

                return $i;
            })
            ->value();
    }

    public function chain($data): Chain
    {
        return new \Yo\Chain($data);
    }

    public function lazyChain($data): LazyChain
    {
        return new \Yo\LazyChain($data);
    }

    public function mathChain($data): MathChain
    {
        return new \Yo\MathChain($data);
    }

    // TODO: this should reject private methods
    public function methodCount($obj = null): int
    {
        $foo = new \ReflectionClass($obj ?? $this);
        return $this->size($foo->getMethods());
    }
}
