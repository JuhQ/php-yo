<?php
namespace Yo;

include_once('chain.php');
include_once('lazy-chain.php');


class Yo
{
    public function lowercase($str)
    {
        return strtolower($str);
    }

    public function uppercase($str)
    {
        return strtoupper($str);
    }

    public function capitalize($str)
    {
        return $this->uppercase($this->first($str)) . $this->lowercase($this->rest($str));
    }

    public function kebabCase($str)
    {
        return $this->lowercase(implode('-', explode(' ', trim($str))));
    }

    public function isString($val)
    {
        return is_string($val);
    }

    public function isArray($val)
    {
        return is_array($val);
    }

    public function isEmpty($val)
    {
        return $this->size($val) === 0;
    }

    public function isFinite($n)
    {
        return $this->isNumber($n) && is_finite($n);
    }

    public function isPositive($n)
    {
        return $this->isFinite($n) && $n > 0;
    }

    public function isNegative($n)
    {
        return $this->isFinite($n) && $n < 0;
    }

    public function isNumber($val)
    {
        return is_int($val) || is_float($val);
    }

    public function isPalindrome($str)
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

    public function size($val)
    {
        if ($this->isString($val)) {
            return strlen($val);
        }

        return count($val);
    }

    // TODO: no tests for this function
    public function random($min = 0, $max = 0)
    {
        if (!$this->isNumber($min)) {
            $min = 0;
        }
        if (!$this->isNumber($max)) {
            $max = 1;
        }

        return mt_rand($min, $max);
    }

    public function range($n)
    {
        return range(0, $n);
    }

    public function times($n)
    {
        return $this->range($n);
    }

    public function inRange($min, $max, $value)
    {
        if (!$this->isNumber($min) || !$this->isNumber($max) || !$this->isNumber($value)) {
            return false;
        }

        return ($min <= $value) && ($value <= $max);
    }

    public function filter($arr, $callback)
    {
        return array_values(array_filter($arr, $callback));
    }

    // TODO: no tests for this function
    public function sample($arr)
    {
        return $this->first(shuffle($arr));
    }

    public function map($arr, $callback = false)
    {
        if (!$callback) {
            if ($this->isString($arr)) {
                return [$arr];
            }
            return $arr;
        }
        return array_map($callback, $arr);
    }

    public function add($a, $b)
    {
        return $a + $b;
    }

    public function subtract($a, $b)
    {
        return $a - $b;
    }

    public function multiply($a, $b)
    {
        return $a * $b;
    }

    public function divide($a, $b)
    {
        return $a / $b;
    }

    public function mean($arr)
    {
        return $this->divide($this->sum($arr), $this->size($arr));
    }

    public function sum($arr)
    {
        return $this->reduce($arr, [$this, 'add'], 0);
    }

    public function factorial($n)
    {
        return $this->reduce($this->rest($this->times($n)), [$this, 'multiply'], 1);
    }

    public function reduce($arr, $callback, $initial)
    {
        return array_reduce($arr, $callback, $initial);
    }

    public function flatten($arr)
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

    public function chain($data)
    {
        return new \Yo\Chain($data);
    }

    public function lazyChain($data)
    {
        return new \Yo\LazyChain($data);
    }
}
