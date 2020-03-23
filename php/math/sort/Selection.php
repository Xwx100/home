<?php


namespace math\sort;

/**
 * 选择排序：两两比较 找到最值 移动
 *
 * Class Selection
 *
 * @package math\sort
 */
class Selection extends Sort {

    public function start(): Selection {
        for ($i = 0; $i < $this->len - $i; ++$i)  {
            $min = $i;
            for ($j = 0; $j < $this->len; ++$j) {
                if ($this->toSort[$j] < $this->toSort[$i]) {
                    $min = $j;
                }
                ++$this->loopTimes;
            }
            if ($min !== $i) {
                list($this->toSort[$i], $this->toSort[$min]) = [$this->toSort[$min], $this->toSort[$i]];
            } else {
                break;
            }
        }

        return $this;
    }
}