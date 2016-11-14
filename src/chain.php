<?php
namespace Yo;

class Chain
{
    private $yo;
    private $data;
    private $actions;

    public function __construct($data)
    {
        $this->yo = new Yo();
        $this->data = $data;
    }

    public function map($callback)
    {
        $this->data = $this->yo->map($this->data, $callback);
        return $this;
    }

    public function filter($callback)
    {
        $this->data = $this->yo->filter($this->data, $callback);
        return $this;
    }

    public function reject($callback)
    {
        $this->data = $this->yo->reject($this->data, $callback);
        return $this;
    }

    public function find($callback, $useBinarySearch = false)
    {
        $this->data = $this->yo->find($this->data, $callback, $useBinarySearch);
        return $this;
    }

    public function findKey($key)
    {
        $this->data = $this->yo->findKey($this->data, $key);
        return $this;
    }

    public function pick($callback)
    {
        $this->data = $this->yo->pick($this->data, $callback);
        return $this;
    }

    public function drop($n)
    {
        $this->data = $this->yo->drop($this->data, $n);
        return $this;
    }

    public function dropRight($n)
    {
        $this->data = $this->yo->dropRight($this->data, $n);
        return $this;
    }

    public function flatten()
    {
        $this->data = $this->yo->flatten($this->data);
        return $this;
    }

    public function reverse()
    {
        $this->data = $this->yo->reverse($this->data);
        return $this;
    }

    public function first()
    {
        $this->data = $this->yo->first($this->data);
        return $this;
    }

    public function rest()
    {
        $this->data = $this->yo->rest($this->data);
        return $this;
    }

    public function reduce($callback, $initial)
    {
        $this->data = $this->yo->reduce($this->data, $callback, $initial);
        return $this;
    }

    public function plug($callback)
    {
        $this->data = $callback($this->data);
        return $this;
    }

    public function value()
    {
        return $this->data;
    }

    public function toJSON(): string
    {
        return json_encode($this->value());
    }
}
