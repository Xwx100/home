<?php


namespace test_global_var;


class TestGlobalVar {

    public $varResult = null;

    public function __construct() {
        $this->run();
    }

    public function run() {
        session_start();
        $_SESSION = [
            'a' => 1
        ];
        $this->varResult = [
            $_SERVER,
            $_GET,
            $_POST,
            $_REQUEST,
            $_COOKIE,
            $_SESSION,
            $_FILES,
            $_ENV
        ];
    }

    public function __toString() {
        return var_export($this->varResult, true);
    }
}

$t = new TestGlobalVar();
echo $t;

$c = function ($var) {
    var_dump($var);
};
$c(...['a', 2]);