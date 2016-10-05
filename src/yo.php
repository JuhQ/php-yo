<?php
namespace Yo;

class Yo
{

    public function map($arr, $callback)
    {
        return array_map($callback, $arr);
    }
}
