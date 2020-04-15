<?php


namespace test_fast;


class Fast {

    public $conf = null;

    public function __construct(array $conf = []) {
        $defaultConf = [
            'loop_times' => 10000,
            'check' => false
        ];
        $this->conf = array_merge($defaultConf, $conf);
        $this->conf['check'] && $this->checkConf();
    }

    public function checkConf() {
        if (empty($this->conf['func'])) {
            throw new \Exception('conf.func 未设置');
        } else {
            if (empty(is_array($this->conf['func']))) {
                throw new \Exception('conf.func 不是数组');
            }
            foreach ($this->conf['func'] as $v) {
                if (empty(is_callable($v))) {
                    throw new \Exception('conf.func 不是所有元素都是函数');
                }
            }
        }
    }

    public function run() {
        $result = [];
        foreach ($this->conf['func'] as $name => $f) {
            $s = microtime(true);
            for ($i = 0; $i < $this->conf['loop_times']; ++$i) {
                call_user_func($f);
            }
            $e = microtime(true);
            $result[$name]['time'] = $e - $s;
        }
        return $result;
    }
}
$f = new Fast([
    'loop_times' => 1000000,
    'func' => [
        function () {
            return implode('_', ['xu', '6']);
        },
        function () {
            return 'xu' . '_' . '6';
        }
    ]
]);
$i = $f->run();
var_dump($i);