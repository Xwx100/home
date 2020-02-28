<?php

//function a($a, $b, ...$c) {
//    var_dump($a);
//    var_dump($b);
//    var_dump($c);
//    var_dump(func_get_args());
//    var_dump(func_num_args());
//    var_dump(func_get_arg(6));
//}
//
//$b = ['6' => 1,2,3];
//a(1, ...$b, ...$b);
//
//var_dump(is_float(111.0));

echo http_build_query(['advertiser_id' => 67565972041, 'fitering' => ["landing_type" => ["EXTERNAL"]]]);
exit();

//var_dump([1,2,3] + [2,3,4]);
//var_dump(array_merge([1,2,3], [2,3,4]));

$two_dimensional = array();

$two_dimensional['foo'] = array('a' => 1, 'b' => 2, 'c' => 3);
$two_dimensional['bar'] = array('a' => 4, 'b' => 5, 'c' =>6);

$one_dimensional = array_reduce($two_dimensional, 'array_merge', array());
var_dump($one_dimensional);

$one_dimensional = array_reduce($two_dimensional, function ($one_dimensional, $value) {
    return array_merge($one_dimensional, array_values($value));
}, array());
var_dump($one_dimensional);
