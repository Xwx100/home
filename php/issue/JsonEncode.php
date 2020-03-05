<?php
/**
 * Created by PhpStorm.
 * User: Xu
 * Date: 2020/3/4
 * Time: 12:46
 */

namespace Issue;


class JsonEncode {

    public static function issue() {
        $a = 14052.34;
        $c = (float)1911.67+(float)930.79+(float)886.01+(float)843.96+(float)820.96+(float)802.74+(float)734.97+(float)685.39+(float)648.46+(float)640.41+(float)633.16+(float)616.73+(float)591.46+(float)562.73+(float)528.99+(float)528.33+(float)487.56+(float)423.73+(float)418.15+(float)356.14;

        var_dump($c);
        $b = ['c' => $a, 'd' => $c];
        $b = json_encode($b);
        echo $b;
    }

    public static function result() {
        echo <<<STR
php版本 7.3.11 才会出现问题  7.0.33不会出现

解决1：float 改成 字符串类型
解决2：修改php配置  serialize_precision=16 可参考：https://segmentfault.com/a/1190000008737065
STR;
    }
}

JsonEncode::issue();
