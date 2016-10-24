<?php
namespace Yo;

class LazyChain
{
    private $yo;
    private $data;
    private $actions;

    public function __construct($data)
    {
        $this->yo = new Yo();
        $this->data = $data;
        $this->actions = [];
    }

    public function map($callback)
    {
        array_push($this->actions, ['action' => 'map', 'callback' => $callback]);
        return $this;
    }

    public function filter($callback)
    {
        array_push($this->actions, ['action' => 'filter', 'callback' => $callback]);
        return $this;
    }

    public function reject($callback)
    {
        array_push($this->actions, ['action' => 'reject', 'callback' => $callback]);
        return $this;
    }

    public function find($callback, $useBinarySearch = false)
    {
        array_push($this->actions, ['action' => 'find', 'callback' => $callback, 'attributes' => $useBinarySearch]);
        return $this;
    }

    public function findKey($key)
    {
        array_push($this->actions, ['action' => 'findKey', 'callback' => $key]);
        return $this;
    }

    public function pick($callback)
    {
        array_push($this->actions, ['action' => 'pick', 'callback' => $callback]);
        return $this;
    }

    public function drop($n)
    {
        array_push($this->actions, ['action' => 'drop', 'callback' => $n]);
        return $this;
    }

    public function dropRight($n)
    {
        array_push($this->actions, ['action' => 'dropRight', 'callback' => $n]);
        return $this;
    }

    public function flatten()
    {
        array_push($this->actions, ['action' => 'flatten']);
        return $this;
    }

    public function reverse()
    {
        array_push($this->actions, ['action' => 'reverse']);
        return $this;
    }

    public function first()
    {
        array_push($this->actions, ['action' => 'first']);
        return $this;
    }

    public function rest()
    {
        array_push($this->actions, ['action' => 'rest']);
        return $this;
    }

    public function reduce($callback, $initial)
    {
        array_push($this->actions, ['action' => 'reduce', 'callback' => $callback, 'attributes' => $initial]);
        return $this;
    }

    public function value()
    {
        $result = $this->data;
        foreach ($this->actions as $value) {
            if (isset($value['attributes'])) {
                $result = $this->yo->{$value['action']}($result, $value['callback'], $value['attributes']);
            } else if (isset($value['callback'])) {
                $result = $this->yo->{$value['action']}($result, $value['callback']);
            } else {
                $result = $this->yo->{$value['action']}($result);
            }
        }

        return $result;
    }

    public function toJSON(): string
    {
        return json_encode($this->value());
    }
}
