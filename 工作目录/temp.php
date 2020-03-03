<?php

////最大的子进程数量
//$maxChildPro = 8;
//
////当前的子进程数量
//$curChildPro = 0;
//
//$var = [];
//
////当子进程退出时，会触发该函数,当前子进程数-1
//function sig_handler($sig)
//{
//    global $curChildPro;
//    switch ($sig) {
//        case SIGCHLD:
//            echo 'SIGCHLD', PHP_EOL;
//            $curChildPro--;
//            break;
//    }
//}
//
////配合pcntl_signal使用，简单的说，是为了让系统产生时间云，让信号捕捉函数能够捕捉到信号量
//declare(ticks = 1);
//
////注册子进程退出时调用的函数。SIGCHLD：在一个进程终止或者停止时，将SIGCHLD信号发送给其父进程。
//pcntl_signal(SIGCHLD, "sig_handler");
//
//while (true) {
//    $curChildPro++;
//    $pid = pcntl_fork();
//    echo 'pid: ' . $pid . $curChildPro . PHP_EOL;
//    if ($pid) {
//        echo '父进程: ' . $pid . $curChildPro . PHP_EOL;
//        $var[] = $pid;
//        var_dump($var);
////父进程运行代码,达到上限时父进程阻塞等待任一子进程退出后while循环继续
//        if ($curChildPro >= $maxChildPro) {
//            pcntl_wait($status);
//        }
//    } else {
////子进程运行代码
//        echo '子进程: ' . $pid . $curChildPro . PHP_EOL;
//        $var[] = $curChildPro;
//        $s = rand(2, 6);
//        var_dump($var);
//        sleep($s);
//        echo "child sleep $s second quit", PHP_EOL;
//        exit;
//    }
//}
//$parentPid = posix_getpid();
//echo "parent progress pid:{$parentPid}\n";
//$childList = array();
//// 创建消息队列,以及定义消息类型(类似于数据库中的库)
//$id = ftok(__FILE__,'m');
//if (msg_queue_exists($id)) {
//    echo '111111111111';
//    var_dump(msg_stat_queue(msg_get_queue($id)));
////    $ok = msg_remove_queue(msg_get_queue($id));
////    if ($ok) {
////        echo 'remove msg_queue';
////    }
//} else {
//    $msgQueue = msg_get_queue($id);
//}
//
//exit();
//const MSG_TYPE = 5;
//// 生产者
//function producer(){
//    global $msgQueue;
//    $pid = posix_getpid();
//    $repeatNum = 5;
//    for ( $i = 1; $i <= $repeatNum; $i++) {
////        $str = "({$pid})progress create! {$i}";
//        $a = [1,2,3];
//        msg_send($msgQueue,MSG_TYPE,$a);
//        $rand = rand(1,3);
//        sleep($rand);
//    }
//}
//// 消费者
//function consumer(){
//    global $msgQueue;
//    var_dump($msgQueue);
//    $pid = posix_getpid();
//    $repeatNum = 6;
//    for ( $i = 1; $i <= $repeatNum; $i++) {
//        $rel = msg_receive($msgQueue,MSG_TYPE,$msgType,1024,$message);
//        echo "msg_type: {$msgType}" . PHP_EOL;
//        var_dump($message);
////        echo "{$message} | consumer({$pid}) destroy \n";
//        $rand = rand(1,3);
//        sleep($rand);
//    }
//}
//function createProgress($callback){
//    $pid = pcntl_fork();
//    if ($pid == -1) {
//        // 创建失败
//        exit("fork progress error!\n");
//    } else if ($pid == 0) {
//        // 子进程执行程序
//        $pid = posix_getpid();
//        $callback();
//        exit("({$pid})child progress end!\n");
//    }else{
//        // 父进程执行程序
//        return $pid;
//    }
//}
//// 3个写进程
//for ($i = 0; $i < 3; $i ++ ) {
//    $pid = createProgress('producer');
//    $childList[$pid] = 1;
//    echo "create producer child progress: {$pid} \n";
//}
//// 2个读进程
//for ($i = 0; $i < 2; $i ++ ) {
//    $pid = createProgress('consumer');
//    $childList[$pid] = 1;
//    echo "create consumer child progress: {$pid} \n";
//}
//// 等待所有子进程结束
//while(!empty($childList)){
//    $childPid = pcntl_wait($status);
//    if ($childPid > 0){
//        unset($childList[$childPid]);
//    }
//}
//echo "({$parentPid})main progress end!\n";

var_dump(array_intersect(['1', '2'], [1, 2]));


var_dump(array_values([1 => [1], 2 => [2]]));

echo stripos('11creative_ids', 'creative_id');

abstract class A {
    public static $instance = null;

    /**
     * @return A
     */
    public static function getInstance() {
        $className = get_called_class();
        if (!static::$instance instanceof $className) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function aa() {
        echo get_called_class();
    }
}

class B extends A {
//    public static $instance = null;
}

class C extends A {
//    public static $instance = null;
}


$b = B::getInstance();
$c = C::getInstance();
$b->aa();
$c->aa();
var_dump($b, $c);
