<?php
namespace Yo;

include_once('./yo.php');

$yo = new Yo();

$methods = $yo->map($yo->listMethods(), function ($method) {
    return $method->name;
});

echo json_encode($methods);
