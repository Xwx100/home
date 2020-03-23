<?php


namespace math\sort;


/**
 * 冒泡算法：两两排序 找 最小值|最大值 并 移到 最前|最后
 *
 * Class Bubble
 *
 * @package math\sort
 */
class Bubble extends Sort {

    /**
     * time_mid = O(n^2) | space = O(1)
     *
     * @return Bubble
     */
    public function start(): Bubble {
        $toSort = &$this->toSort;
        $count = count($toSort) - 1;
        $p = &$this->loopTimes;

        for ($i = 0; $i < $count; ++$i) {
            $ok = true;
            for ($j = 0; $j < $count - $i; ++$j) { // $count - $i 减少 循环次数
                // 两两比较 最大值移到最后
                if ($toSort[$j] > $toSort[$j + 1]) {
                    list($toSort[$j], $toSort[$j + 1]) = [$toSort[$j + 1], $toSort[$j]];
                    $ok && $ok = false;
                }
                ++$p;
                // 提前 退出
                if ($ok) {
                    break;
                }
            }
        }

        return $this;
    }
}