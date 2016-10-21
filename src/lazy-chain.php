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
            } else {
                $result = $this->yo->{$value['action']}($result, $value['callback']);
            }
        }

        return $result;
    }

    public function toJSON(): string
    {
        return json_encode($this->value());
    }
}
