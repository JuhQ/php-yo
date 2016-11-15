<?php
declare(strict_types=1);

namespace Yo;

include_once('chain.php');
include_once('lazy-chain.php');
include_once('math-chain.php');

class Yo
{
    private $uniqueIdValue = 0;

    public function always(): bool
    {
        return true;
    }

    public function never(): bool
    {
        return false;
    }

    public function noop()
    {
    }

    public function now(): int
    {
        return time();
    }

    public function uniqueId(): int
    {
        return $this->uniqueIdValue++;
    }

    public function isBoolean($val): bool
    {
        return is_bool($val);
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

    public function isFloat($val): bool
    {
        return is_float($val);
    }

    public function isNull($val): bool
    {
        return is_null($val);
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

    public function isEven(int $n): bool
    {
        return $n % 2 === 0;
    }

    public function isOdd(int $n): bool
    {
        return !$this->isEven($n);
    }

    public function isFalsey($val): bool
    {
        return !$val;
    }

    public function isTruthy($val): bool
    {
        return !$this->isFalsey($val);
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

    public function compact(array $arr): array
    {
        return $this->filter($arr, [$this, 'isTruthy']);
    }

    private function getTruthyValuesFromArray(array $arr, $callback): array
    {
        return $this->map($arr, function ($item) use ($callback) {
            if (isset($callback) && $this->isFunction($callback)) {
                return $callback($item);
            }

            return $this->isTruthy($item);
        });
    }

    public function every(array $arr, $callback = null): bool
    {
        $results = $this->getTruthyValuesFromArray($arr, $callback);
        return $this->size($this->compact($results)) === $this->size($arr);
    }

    public function some(array $arr, $callback = null): bool
    {
        $results = $this->getTruthyValuesFromArray($arr, $callback);
        return $this->size($this->compact($results)) > 0;
    }

    public function none(array $arr, $callback = null): bool
    {
        $results = $this->getTruthyValuesFromArray($arr, $callback);
        return $this->size($this->compact($results)) === 0;
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
        return implode('', $this->times($n - 1, (string) $str));
    }

    public function partition(array $arr, $predicate): array
    {
        return $this->reduce($arr, function ($initial, $val) use ($predicate) {
            array_push($initial[$this->booleanToInt(!$predicate($val))], $val);
            return $initial;
        }, [[], []]);
    }

    public function fill(array $arr, $val): array
    {
        return $this->map($arr, (string) $val);
    }

    public function pluck(array $arr, $val): array
    {
        return $this->map($arr, (string) '.' . $val);
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

    public function length($val): int
    {
        return $this->size($val);
    }

    public function trim(string $val): string
    {
        return trim($val);
    }

    public function removeSubstrings(string $str, $substrings): string
    {
        $subs = $this->isString($substrings) ?
            $this->map(explode(',', $substrings), [$this, 'trim']) :
            $substrings;

        return $this->reduce($subs, function ($initial, $sub) use ($subs) {
            $value = str_replace($subs, '', $initial);
            return strpos($value, $sub) ? $this->removeSubstrings($value, $sub) : $value;
        }, str_replace($subs, '', $str));
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

    public function times(int $n, $callback = null): array
    {
        return $callback ? $this->map($this->range($n), $callback) : $this->range($n);
    }

    public function inRange(int $a, int $b, int $val): bool
    {
        return $this->gte($val, $a) && $this->lte($val, $b);
    }

    public function between(int $a, int $b, int $val): bool
    {
        return $this->inRange($a, $b, $val);
    }

    public function filter(array $arr, $callback): array
    {
        return $this->values(array_filter($arr, $callback, ARRAY_FILTER_USE_BOTH));
    }

    public function reject(array $arr, $callback): array
    {
        return $this->filter($arr, $this->negate($callback));
    }

    public function sample(array $arr)
    {
        return $this->first($this->shuffle($arr));
    }

    public function shuffle(array $arr)
    {
        return shuffle($arr);
    }

    public function contains(array $haystack, $needle): bool
    {
        return in_array($needle, $haystack, true);
    }

    public function difference(array $a, array $b): array
    {
        return $this->reject($this->merge($a, $b), function ($val) use ($a, $b) {
            return $this->contains($a, $val) && $this->contains($b, $val);
        });
    }

    public function map($arr, $callback = false): array
    {
        if (!$callback) {
            if ($this->isString($arr)) {
                return [$arr];
            }
            return $arr;
        }

        $createCallback = function ($value) use ($callback) {
            if ($this->isFunction($callback)) {
                return $callback($value);
            }

            if ($this->isString($callback)) {
                if ($this->first($callback) === '.') {
                    return $this->get($value, $callback);
                }
            }

            return $callback;
        };

        return array_map($createCallback, $arr);
    }

    public function add(int $a, int $b): int
    {
        return $a + $b;
    }

    public function addSelf(int $a): int
    {
        return $a + $a;
    }

    public function subtract(int $a, int $b): int
    {
        return $a - $b;
    }

    public function multiply(int $a, int $b): int
    {
        return $a * $b;
    }

    public function divide(int $a, int $b): int
    {
        return $a / $b;
    }

    public function mean(array $arr): int
    {
        return $this->divide($this->sum($arr), $this->size($arr));
    }

    public function sum(array $arr): int
    {
        return $this->reduce($arr, [$this, 'add'], 0);
    }

    public function factorial($n): int
    {
        return $this->reduce($this->rest($this->times($n)), [$this, 'multiply'], 1);
    }

    public function reduce(array $arr, $callback, $initial)
    {
        return array_reduce($arr, $callback, $initial);
    }

    public function reduceRight(array $arr, $callback, $initial)
    {
        return $this->reduce($this->reverse($arr), $callback, $initial);
    }

    public function flatten(array $arr): array
    {
        if ($this->isEmpty($arr)) {
            return [];
        }

        return $this->reduce($arr, function ($a, $b) {
            return $this->merge($a, $this->isArray($b) ? $this->flatten($b) : [$b]);
        }, []);
    }

    public function merge(array $a, array ...$b): array
    {
        return array_merge($a, ...$b);
    }

    public function duplicate(array $arr): array
    {
        return $this->merge($arr, $arr);
    }

    public function extend(array ...$args)
    {
        return $this->reduce($args, function ($initial, $arg) {
            foreach ($arg as $key => $value) {
                $initial[$key] = $value;
            }

            return $initial;
        }, []);
    }

    public function max(array $arr)
    {
        return max($arr);
    }

    public function min(array $arr)
    {
        return min($arr);
    }

    public function initial(array $arr)
    {
        return $this->slice($arr, 0, $this->size($arr) - 1);
    }

    public function head(array $arr)
    {
        return $this->first($arr);
    }

    public function tail(array $arr)
    {
        return $this->rest($arr);
    }

    public function first($val)
    {
        return $this->nth($val, 0);
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

        return $this->slice($val, 1);
    }

    public function firstKey($val)
    {
        return $this->first($this->keys($val));
    }

    public function firstValue($val)
    {
        return $this->first($this->values($val));
    }

    public function slice(array $val, int $n, $length = null): array
    {
        return array_slice($val, $n, $length);
    }

    public function drop(array $arr, int $n): array
    {
        return $this->slice($arr, $n);
    }

    public function dropRight(array $arr, int $n): array
    {
        if ($n > $this->size($arr) - 1) {
            return [];
        }

        return $this->slice($arr, 0, $this->size($arr) - $n);
    }

    public function indexOf(array $arr, $value, $fromIndex = null)
    {
        return array_search($value, $fromIndex ? $this->slice($arr, $fromIndex) : $arr);
    }

    public function passthru()
    {
        return $this->first(func_get_args());
    }

    public function next(array $arr, int $n)
    {
        return $this->nth($arr, $n + 1);
    }

    public function previous(array $arr, int $n)
    {
        return $this->nth($arr, $n - 1);
    }

    public function nth($arr, int $n)
    {
        return $arr[$n];
    }

    public function nthArg(int $n)
    {
        return function (...$args) use ($n) {
            return $this->nth($args, $n);
        };
    }

    public function everyNth(array $arr, int $n): array
    {
        return $this->filter($arr, function ($val, $i) use ($n) {
            return ($i + 1) % $n === 0;
        });
    }

    public function everyNthWord($val, int $n): array
    {
        return $this->everyNth($this->words($val), $n);
    }

    public function everyNthLetter($val, int $n): array
    {
        return $this->everyNth($this->letters($val), $n);
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

    public function permutations(array $arr)
    {
        if ($this->isEmpty($arr)) {
            return [[]];
        }

        $head = $this->first($arr);
        $tail = $this->tail($arr);
        $arrSize = $this->size($arr);

        return $this->reduce($this->permutations($tail), function ($initial, $value) use ($arr, $head, $arrSize) {
            $result = $this->times($arrSize, function ($i) use ($value, $head) {
                return $this->splice($value, $i, 0, $head);
            });

            return $this->skipDuplicates(array_merge(...[$initial], ...[$result]));
        }, []);
    }

    public function reverse($val)
    {
        if ($this->isString($val)) {
            return implode('', $this->reverse(str_split($val)));
        }

        return array_reverse($val);
    }

    public function reverseWords($str): string
    {
        return implode(' ', $this->reverse($this->words($str)));
    }

    public function reverseInPlace(string $str): string
    {
        return $this->reverse(implode(' ', $this->reverse(explode(' ', $str))));
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

    public function fibonacci(int $n = 0): int
    {
        if ($n < 1) {
            return 0;
        }

        if ($n <= 2) {
            return 1;
        }

        return $this->fibonacci($n - 1) + $this->fibonacci($n - 2);
    }

    public function lastOfTheLastOfTheLast(array $arr)
    {
        $lastItem = $this->last($arr);

        if ($this->isArray($lastItem) && $this->size($lastItem)) {
            return $this->lastOfTheLastOfTheLast($lastItem);
        }

        return $lastItem;
    }

    public function missingNumber(array $arr): int
    {
        $n = $this->size($arr) + 1;
        $expected = $n * ($n + 1) / 2;
        return $expected - $this->sum($arr);
    }

    public function findLargestSubArrayBySum(array $arrays): array
    {
        $maxes = $this->map($arrays, function ($arr) {
            return $this->sum($arr);
        });

        $max = $this->max($maxes);
        $index = $this->indexOf($maxes, $max);
        return ['index' => $index, 'item' => $arrays[$index], 'value' => $max];
    }

    public function findPairsBySum(array $arr, $targetValue): array
    {
        $i = 0;
        return $this->reduce($arr, function ($initial, $value) use ($arr, $targetValue, &$i) {
            $filtered = $this->filter($this->drop($arr, $i), function ($v) use ($value, $targetValue) {
                return $value + $v === $targetValue;
            });

            $i++;

            if ($this->size($filtered)) {
                array_push($initial, [$value, $filtered[0]]);
            }

            return $initial;
        }, []);
    }

    public function findDuplicates(array $arr, $binarySearch = false): array
    {
        $i = 0;
        return $this->reduce($arr, function ($initial, $value) use ($arr, $binarySearch, &$i) {
            $filtered = $this->filter($this->drop($arr, $i + 1), function ($v) use ($value) {
                return $this->isEqual($value, $v);
            });

            $i++;

            if ($this->size($filtered) && !$this->find($initial, $value, $binarySearch)) {
                array_push($initial, $filtered[0]);
            }

            return $initial;
        }, []);
    }

    public function skipDuplicates(array $arr, $binarySearch = false)
    {
        $duplicates = $this->findDuplicates($arr, $binarySearch);

        return $this->reduce($arr, function ($initial, $value) use ($duplicates, $binarySearch) {
            $inDuplicates = $this->find($duplicates, $value, $binarySearch);
            if ($inDuplicates && !$this->find($initial, $value, $binarySearch)) {
                array_push($initial, $value);
            }

            if (!$inDuplicates) {
                array_push($initial, $value);
            }

            return $initial;
        }, []);
    }

    public function pick(array $arr, $query): array
    {
        return $this->reduce($arr, function ($value, $item) use ($query) {
            foreach ($query as $key => $val) {
                if (isset($item[$key]) && $item[$key] && $this->isEqual($item[$key], $val)) {
                    array_push($value, $item);
                }
            }

            return $value;
        }, []);
    }

    public function omit(array $arr, $query): array
    {
        return $this->reduce($arr, function ($value, $item) use ($query) {
            foreach ($query as $key => $val) {
                if (!isset($item[$key]) || !$this->isEqual($item[$key], $val)) {
                    array_push($value, $item);
                }
            }

            return $value;
        }, []);
    }

    public function findLargestSum(array $arr): int
    {
        $largest = $this->max($arr);
        $duplicates = $this->findDuplicates($arr);
        $callback = function ($i) use ($largest) {
            return $i === $largest;
        };

        if ($this->find($duplicates, $callback)) {
            return $this->addSelf($largest);
        }

        return $largest + $this->max($this->reject($arr, $callback));
    }

    public function greatestCommonDivisor(int $a, int $b): int
    {
        if ($b === 0) {
            return $a;
        }

        return $this->greatestCommonDivisor($b, $a % $b);
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

    public function callFunctor($val, $callback)
    {
        return $callback($val);
    }

    public function negate($callback)
    {
        return function (...$args) use ($callback) {
            return !$callback(...$args);
        };
    }

    public function flip($callback)
    {
        return function (...$args) use ($callback) {
            return $callback($this->reverse($args));
        };
    }

    public function toArray(...$args): array
    {
        return $this->flatten($args);
    }

    private function doPipe($funcs, $args)
    {
        $data = $this->rest($funcs);
        $callback = [$this, 'callFunctor'];
        $initial = $this->first($funcs)(...$args);

        return $this->reduce($data, $callback, $initial);
    }

    public function pipe(...$funcs)
    {
        return function (...$args) use ($funcs) {
            return $this->doPipe($funcs, $args);
        };
    }

    public function pipeRight(...$funcs)
    {
        return function (...$args) use ($funcs) {
            return $this->doPipe($this->reverse($funcs), $args);
        };
    }

    public function findKey($obj, $key)
    {
        return $obj[$key] ?? false;
    }

    public function get(array $val, string $path)
    {
        $keys = $this->compact(explode('.', $path));
        return $this->reduce($keys, [$this, 'findKey'], $val);
    }

    public function values(array $arr): array
    {
        return array_values($arr);
    }

    public function keys(array $arr): array
    {
        return array_keys($arr);
    }

    public function each(array $arr, $callback)
    {
        foreach ($arr as $key => $value) {
            $callback($value, $key, $arr);
        }
    }

    public function find(array $arr, $item, $useBinarySearch = false)
    {
        if ($useBinarySearch) {
            return $arr[$this->binarySearch($arr, $item)];
        }

        $result = false;
        $found = false;

        for ($i = $this->size($arr) - 1; $i >= 0; $i--) {
            if ($this->isFunction($item)) {
                $found = $item($arr[$i]);
            } else {
                $found = $arr[$i] === $item;
            }

            if ($found) {
                $result = $arr[$i];
                break;
            }
        }

        return $result;
    }

    public function matches($obj, $props): bool
    {
        $result = $this->find($this->keys($obj), function ($key) use ($obj, $props) {
            if (!isset($props[$key])) {
                return false;
            }

            return $obj[$key] === $props[$key];
        });
        return $this->isTruthy($result);
    }

    public function where(array $arr, $props): array
    {
        return $this->filter($arr, function ($entry) use ($props) {
            return $this->matches($entry, $props);
        });
    }

    public function chunk(array $arr, int $size): array
    {
        return array_chunk($arr, $size);
    }

    public function splitBy($val, $delimiter): array
    {
        return preg_split('/' . $delimiter . '/', $this->isFunction($val) ? $val() : $val);
    }

    public function words($str): array
    {
        return $this->splitBy($str, ' ');
    }

    public function letters($str): array
    {
        return $this->reject($this->splitBy($str, ''), function ($str) {
            $delimiterPattern = '/\.| |,|!|\?|:|;|-|_/';
            return $this->isEmpty($str) || preg_match($delimiterPattern, $str);
        });
    }

    public function wordCount(string $str): int
    {
        return $this->size($this->words($str));
    }

    public function memoize($callback)
    {
        $memo = [];
        return function (...$args) use ($callback, $memo) {
            $key = serialize($args);
            if (isset($memo[$key])) {
                return $memo[$key];
            }

            $memo[$key] = $callback(...$args);
            return $memo[$key];
        };
    }

    public function union(array $a, array $b): array
    {
        return $this->skipDuplicates($this->merge($a, $b));
    }

    public function once($fn)
    {
        $done = false;
        $value = null;
        return function (...$args) use ($fn, &$done, &$value) {
            if (!$done) {
                $done = true;
                $value = $fn(...$args);
            }

            return $value;
        };
    }

    public function after($n, $fn)
    {
        $counter = 1;
        return function (...$args) use ($n, $fn, &$counter) {
            return $counter++ >= $n ? $fn(...$args) : $this->noop();
        };
    }

    public function before($n, $fn)
    {
        $counter = 0;
        return function (...$args) use ($n, $fn, &$counter) {
            return $counter++ < $n ? $fn(...$args) : $this->noop();
        };
    }

    public function pairs($val)
    {
        return array_map(null, $this->keys($val), $this->values($val));
    }

    public function wrap($fn, $callback)
    {
        return function (...$args) use ($fn, $callback) {
            return $callback($fn, ...$args);
        };
    }

    public function booleanToInt(bool $val): int
    {
        return (int) $val;
    }

    public function zip(array ...$args): array
    {
        return array_map(null, ...$args);
    }

    public function zipObject(array $a, array $b): array
    {
        return array_combine($a, $b);
    }

    public function invert(array $val): array
    {
        return $this->zipObject($this->values($val), $this->keys($val));
    }

    public function splice(array $arr, ...$args): array
    {
        array_splice($arr, ...$args);
        return $arr;
    }

    public function sort(array $arr): array
    {
        sort($arr);
        return $arr;
    }

    public function reservedWords(): array
    {
        return [
            'and', 'or', 'xor', '__FILE__', 'exception', '__LINE__',
            'array', 'as', 'break', 'case', 'class', 'const', 'continue',
            'declare', 'default', 'die', 'do', 'echo', 'else', 'elseif',
            'empty', 'enddeclare', 'endfor', 'endforeach', 'endif',
            'endswitch', 'endwhile', 'eval', 'exit', 'extends', 'for',
            'foreach', 'function', 'global', 'if', 'include', 'include_once',
            'isset', 'list', 'new', 'print', 'require', 'require_once', 'return',
            'static', 'switch', 'unset', 'use', 'var', 'while', '__FUNCTION__',
            '__CLASS__', '__METHOD__', 'final', 'php_user_filter', 'interface',
            'implements', 'extends', 'public', 'private', 'protected', 'abstract',
            'clone', 'try', 'catch','throw', 'cfunction', 'old_function', 'this'
        ];
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

    public function listMethods($obj = null): array
    {
        $foo = new \ReflectionClass($obj ?? $this);
        return $foo->getMethods(\ReflectionMethod::IS_PUBLIC);
    }

    public function methodCount($obj = null): int
    {
        return $this->size($this->listMethods($obj));
    }
}
