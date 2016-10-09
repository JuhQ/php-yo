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

    public function reduce($callback, $initial)
    {
        $this->data = $this->yo->reduce($this->data, $callback, $initial);
        return $this;
    }

    public function value()
    {
        return $this->data;
    }
}
