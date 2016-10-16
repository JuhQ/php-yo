<?php
namespace Yo;

class MathChain
{
    private $yo;
    private $data;
    private $actions;

    public function __construct($data)
    {
        $this->yo = new Yo();
        $this->data = $data;
    }

    public function add($val)
    {
        $this->data = $this->yo->add($this->data, $val);
        return $this;
    }

    public function addSelf()
    {
        $this->data = $this->yo->addSelf($this->data);
        return $this;
    }

    public function subtract($val)
    {
        $this->data = $this->yo->subtract($this->data, $val);
        return $this;
    }

    public function multiply($val)
    {
        $this->data = $this->yo->multiply($this->data, $val);
        return $this;
    }

    public function divide($val)
    {
        $this->data = $this->yo->divide($this->data, $val);
        return $this;
    }

    public function mean($val)
    {
        $this->data = $this->yo->mean($this->yo->flatten([$this->data, $val]));
        return $this;
    }

    public function sum($val)
    {
        $this->data = $this->yo->sum($this->yo->flatten([$this->data, $val]));
        return $this;
    }

    public function value()
    {
        return $this->data;
    }
}
