<?php
/**
 * 用于测试 唯一ID
 * Created by PhpStorm.
 * User: Xu
 * Date: 2020/3/5
 * Time: 15:45
 */

namespace Issue;


class XuProcess {

    const UUID_KEY = 'gen_uuid';
    public static $queue = [];
    public static $info = [
        'process'    => 4,
        'loop_times' => 10000
    ];
    public static $pidInfo = [];
    public static $r = null;
    public static $op = [
        'host'       => '127.0.0.1',
        'port'       => 6379,
        'password'   => '',
        'select'     => 0,
        'timeout'    => 0,
        'expire'     => 0,
        'persistent' => false,
        'prefix'     => '',
    ];


    /**
     *  生产
     */
    public function producer() {
        $process = self::$info['process'];
        $loopTimes = self::$info['loop_times'];

        $loopTime = intval($loopTimes / $process);
        $remain = $loopTimes % $process;

        for ($i = 0; $i < $process; $i++) {
            array_push(self::$queue, $loopTime);
        }
        if (!empty($remain)) {
            array_push(self::$queue, $remain);
        }
    }

    /**
     * 消耗
     */
    public function start() {
        self::$r = self::getRedis();
        $i = self::$r->sCard(self::UUID_KEY);
        if ($i) {
            self::$r->del(self::UUID_KEY);
            echo "key=" . self::UUID_KEY . " deleted" . PHP_EOL;
        }

        foreach (self::$queue as $args) {
            $ppid = pcntl_fork();
            self::$pidInfo[$ppid] = $ppid;
            if ($ppid === -1) {
                print_r("拷贝 子进程错误 错误码={$ppid}");
                continue;
            } elseif ($ppid) {
                // father
            } else {
                // son
                call_user_func_array([__CLASS__, 'task'], [$args]);
                exit();
            }
        }

        while (self::$pidInfo) {
            self::$pidInfo = array_filter(self::$pidInfo, function ($ppid) {
                pcntl_waitpid($ppid, $status);
                var_dump($status);
                if ($status !== -1) {
                    return false;
                }
                return true;
            });
        }

        $count = self::$r->sCard(self::UUID_KEY);
        $loopTimes = self::$info['loop_times'];
        if ($count != $loopTimes) {
            print_r("no_repeat_count={$count} != total_count={$loopTimes} 循环次数:{$loopTimes} 有重复");
        } else {
            print_r("无重复 count={$count} loop_times={$loopTimes}");
        }
    }


    /**
     * 消耗的任务
     *
     * @param $args
     */
    public function task($args) {
        $r = self::getRedis();

        $testKey = self::UUID_KEY;

        for ($i = 0; $i < $args; $i++) {
            $uid = md5(uniqid(md5(microtime(true)), true));
            $r->sAdd($testKey, $uid);
        }

        $pid = posix_getpid();
        $ppid = posix_getppid();
        echo "ppid={$ppid} pid={$pid} test {$args}" . PHP_EOL;

        exit();
    }

    /**
     * 获取redis 各自进程负责各自的redis
     *
     * @return \Redis
     */
    public static function getRedis() {
        $r = new \Redis();
        $r->connect(self::$op['host'], self::$op['port'], 10);
        return $r;
    }
}


$s = time();

$argv = $_SERVER['argv'];
parse_str($argv[1], $argv1);

// params default
foreach ($argv1 as $varName => $varValue) {
    XuProcess::$info[$varName] = $varValue;
}


$p = new XuProcess();
$p->producer();

var_dump(XuProcess::$queue);

$p->start();

$e = time();

print_r(sprintf('总运行时间：%s-%s=%s', $s, $e, $e - $s));
