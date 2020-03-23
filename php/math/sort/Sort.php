<?php


namespace math\sort;

/**
 * 排序算法 约束
 * 衡量指标 = 时间复杂度(time) + 空间复杂度(space) + 稳定(stability)
 *
 * 指标定义：
 * 时间复杂度 => 平均(time_mid) + 最坏(time_min) + 最好(time_max)
 * 时间复杂度定义：是指执行当前算法所消耗的时间，一般相当于循环次数 o(n^2)
 * 空间复杂度定义：是指执行当前算法需要占用多少内存空间
 * 稳定：如果a原本在b前面，而a=b，排序之后a仍然在b的前面
 * 不稳定：如果a原本在b的前面，而a=b，排序之后 a 可能会出现在 b 的后面。
 *
 * Class SortInterface
 *
 * @package math\sort
 */
abstract class Sort {

    /**
     * 成功排序数组
     *
     * @var array|null
     */
    protected $toSort = null;
    /**
     * @var int|null 数组长度
     */
    protected $len = null;
    /**
     * @var int|null 循环次数
     */
    protected $loopTimes = null;

    public function __construct(array $arr) {
        $this->loopTimes = 0;
        $this->len = count($arr) - 1;
        $this->toSort = $arr;
    }

    /**
     * @return $this
     */
    abstract public function start();

    /**
     * @return array
     */
    public function out(): array {
        $tmp = [];
        foreach ($this as $k => $v) {
            $tmp[$k] = $v;
        }

        return $tmp;
    }
}