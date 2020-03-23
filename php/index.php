<?php
namespace php;

error_reporting(E_ALL ^ E_WARNING);

require  __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use math\Sort;

(new Sort())->start(array_merge(array_reverse(range(0, 49)), range(50, 99)));