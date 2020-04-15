<?php
/**
 * 测试 框架 性能
 */

namespace test_frame;


use SebastianBergmann\CodeCoverage\Report\PHP;
use spec\League\Flysystem\Cached\CachedAdapterSpec;

class Frame {

    protected static $conf = null;
    /**
     * @var string index => '索引匹配' re => 're匹配'
     */
    public static $handleAbInfoM = null;
    /**
     * 处理 结果
     *
     * @var null
     */
    protected static $result = null;

    /**
     * Frame constructor.
     */
    public function __construct() {
        self::$conf = include 'conf.php';
        self::$handleAbInfoM = self::$conf['info_group_m'];
        if (self::$handleAbInfoM === 'index' && count(self::getInfoGroup()) !== 7) {
            throw new \Exception('index模式下：ab信息归类的数组长度必须等于7');
        }
    }

    /**
     * 获取框架 配置
     *
     * @return array
     */
    public static function getFrame(): array {
        return self::$conf['frame'];
    }

    /**
     * ab 信息分类
     *
     * @return array
     */
    public static function getInfoGroup(): array {
        return self::$conf['info_group'];
    }

    /**
     * @param array $prop
     *
     * @return int
     */
    public static function getLoopTimes(array $prop): int {
        return $prop['loop_times'] ?: 5;
    }

    /**
     * 测试
     */
    public function run() {
        foreach ($this->getFrame() as $f => $prop) {
            if (empty($prop['ab_str'])) {
                $prop['ab_str'] = self::getAbStr($prop);
            }
            for ($i = 0; $i < self::getLoopTimes($prop); ++$i) {
                $j = $i + 1;
                $args = [$j, $prop['url']];
                var_dump(sprintf('ab 第%s次 开始测试 %s', ...$args));
                $this->handleAb($prop);
                var_dump(sprintf('ab 第%s次 结束测试 %s', ...$args));
            }
        }
    }

    /**
     * @return null
     */
    public function getResult() {
        return self::$result;
    }

    public function handleAb(array $prop) {
        $str = self::genAbResult($prop['ab_str']);
        $this->handleAbResult($str);
        return $this;
    }

    /**
     * @param string $str
     *
     * @return $this
     * @throws \Exception
     */
    protected function handleAbResult(string $str) {
        $result = &self::$result;
        $arr = explode(PHP_EOL, $str);
        $group = [];
        $groupIndex = 0;
        $arrL = count($arr) - 1;
        foreach ($arr as $i => $v) {
            if (empty($v) || (strlen($v) === 1 || $i === $arrL) && $group) {
                $ii = self::get_group_i($group, $groupIndex);
                if (isset($ii)) {
                    if (empty($result[$groupIndex]['head'])) {
                        ($head = self::getInfoGroup()[$ii]) && ($result[$groupIndex]['head'] = $head);
                    }
                    $result[$groupIndex]['body'][] = self::handleAbBody($group);
                    ++$groupIndex;
                }
                $group = [];
                continue;
            }
            array_push($group, $v);
        }

        if (empty($result)) {
            throw new \Exception('ab 执行 未返回 结果');
        }
        return $this;
    }

    /**
     * 处理 ab 信息
     *
     * @param array $body
     *
     * @return array
     */
    public static function handleAbBody(array $body): array {
        return array_map(function ($v) {
            $vv = explode(':  ', $v);
            $vv = self::trimArray($vv);
            $vv1 = end($vv);
            if (intval($vv1) !== 0) {
                $vv1I = strpos($vv1, ' ');
                $vv1I && ($vv1 = [substr($vv1, 0, $vv1I), substr($vv1, $vv1I + 1)]);
            }
            $vv[key($vv)] = (array)$vv1;
            return $vv;
        }, $body);
    }

    /**
     * 获取 ab 信息 组索引 (模式区分)
     *
     * @param array $tmp
     * @param int   $i
     *
     * @return int|null
     */
    protected static function get_group_i(array $tmp, int $i): ?int {
        if (self::$handleAbInfoM !== 're') {
            return $i;
        }

        $str = implode(' ', $tmp);
        foreach (self::getInfoGroup() as $k => $v) {
            if (self::preg_match_r($v['preg_match'], $str)) {
                return $k;
            }
        }
        return null;
    }

    /**
     * 直接 返回 匹配数组
     *
     * @param string $re
     * @param string $str
     *
     * @return array
     */
    protected static function preg_match_r(string $re, string $str): array {
        preg_match(DIRECTORY_SEPARATOR . $re . DIRECTORY_SEPARATOR, $str, $arr);
        return (array)$arr;
    }

    /**
     * @param $arr
     *
     * @return array|string
     */
    public static function trimArray($arr) {
        if (empty(is_array($arr))) {
            return trim($arr);
        }
        return array_map(function ($v) {
            return self::trimArray($v);
        }, $arr);
    }

    /**
     * ab工具执行  eg: ab -n 100 -c 10 url
     *
     * @param string $str
     *
     * @return string
     */
    protected function genAbResult(string $str): string {
        return self::shellExec($str);
    }

    /**
     * 获取执行命令 eg: ab -n 100 -c 10 url
     *
     * @param array $prop
     *
     * @return string
     */
    protected static function getAbStr(array $prop): string {
        $arr = $prop['ab'];
        $url = $prop['url'];

        array_walk($arr, function (&$v, $k) {
            $v = implode(' ', [$k, $v]);
        });
        unset($v);

        return implode(' ', ['ab', implode(' ', array_values($arr)), $url]);
    }

    /**
     * shell 脚本执行
     *
     * @param string $str
     *
     * @return null|string
     */
    protected static function shellExec(string $str): ?string {
        return shell_exec($str);
    }
}

(new Frame())->run();
