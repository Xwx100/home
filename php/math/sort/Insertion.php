<?php


namespace math\sort;

/**
 * 插入排序：从未排序选出 放置 已排序的相应位置
 *
 * Class Insertion
 *
 * @package math\sort
 */
class Insertion extends Sort {

    public function start(): Insertion {
        // 未排序
        for ($i = 1; $i < $this->len; ++$i) {
            $bak = $this->toSort[$i];
            // 已排序
            for ($j = $i - 1; $j >= 0; -- $j) {
                if ($bak < $this->toSort[$j]) {
                    $this->toSort[$j + 1] = $this->toSort[$j];
                } else {
                    break;
                }
                ++$this->loopTimes;
            }
            $this->toSort[$j + 1] = $bak;
        }

        return $this;
    }
}