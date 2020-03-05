<?php
/**
 * 强制类型
 *
 * Created by PhpStorm.
 * User: Xu
 * Date: 2020/3/4
 * Time: 12:23
 */

namespace Issue;


class MandatoryType {

    public static function issue1() {
        $c = [[1],[2],[3]];
        foreach ($c as &$d) {
            foreach ((array)$d as &$i) {
                $i = 4;
            }
        }

        var_dump($c);
    }

    public static function issue2() {
        $a = null;
        var_dump((array)$a ?? '111');
    }

    public static function result() {
        echo '重新 生成 变量';
    }
}

echo MandatoryType::class;
//foreach ( )
