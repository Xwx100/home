<?php

function a($a, $b, ...$c) {
    var_dump($a);
    var_dump($b);
    var_dump($c);
    var_dump(func_get_args());
    var_dump(func_num_args());
    var_dump(func_get_arg(6));
}

$b = ['6' => 1,2,3];
a(1, ...$b, ...$b);

var_dump(is_float(111.0));