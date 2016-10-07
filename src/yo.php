<?php
namespace Yo;

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

    public function reduce($arr, $callback, $initial)
    {
        return array_reduce($arr, $callback, $initial);
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
}
