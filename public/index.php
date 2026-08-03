<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Hello;

$hello = new Hello();

echo $hello->sayHello();