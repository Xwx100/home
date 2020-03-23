<?php


namespace math;

use math\sort\Bubble;
use math\sort\Selection;
use math\sort\Insertion;

/**
 * 工厂模式 + 单例模式 + 观察者模式 + 对象注入 + 注册模式
 *
 * Class Sort
 *
 * @property Bubble     Bubble
 * @property Selection  Selection
 * @property Insertion  Insertion
 * @package math
 */
class Sort {

    public static $maps = [
        'Bubble' => Bubble::class,
        'Selection' => Selection::class,
        'Insertion' => Insertion::class,
    ];
    public static $instances = [];

    public function start($arr) {
        $tmp = [];
        foreach (self::$maps as $name => $map) {
            $this->$name = [$map, $arr];
            $tmp[$map] = $this->$name->start()->out();
        }
        var_dump($tmp);
    }

    public function __set($name, $value) {
        if (!isset(self::$instances[$name])) {
            self::$instances[$name] = new $value[0]($value[1]);
        }
    }

    public function __get($name) {
        return self::$instances[$name];
    }
}