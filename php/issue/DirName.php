<?php
/**
 * Created by PhpStorm.
 * User: Xu
 * Date: 2020/3/5
 * Time: 18:50
 */

namespace Issue;


class DirName {

    public static function issue() {
        echo "1) " . dirname("etc/tee/passwd/.") . PHP_EOL; // 1) /etc
        echo "2) " . dirname("/etc/etc2/") . PHP_EOL; // 2) / (or \ on Windows)
        echo "3) " . dirname(""); // 3) .
    }

    public static function result() {
        print_r("返回当前文件目录名   但当字符串/后面不跟着符号就算文件");
    }
}

DirName::issue();
