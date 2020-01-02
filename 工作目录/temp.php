<?php

class A {

    public static function confTypeFunc(array $game, callable $cost = null, callable $other = null, ...$extra) {
        if ($game['configs_type'] === 'toutiao' && is_callable($cost)) {
            return call_user_func($cost, $game);
        } elseif ($game['configs_type'] === 'gdt' && is_callable($other)) {
            return call_user_func($other, $game);
        }
        return false;
    }


    public static function handleResult(array $game, array $result) {
        $configs = self::getConfigs($game);
        self::confTypeFunc($game, function ($game) use ($result, $configs) {
            if ((float)$configs['cost_r'] > (float)$result['cost_r']) {
                return;
            }
            try {
                $locked = self::getModGame()->where(['id' => $game['id']])->lock(true)->find();
                if ($locked) {
                    $k = self::mediaFunc($game, function () use ($result) {
                        return 'ad_id';
                    }, function () use ($result) {
                        return 'adgroup_id';
                    });
                    $where = [
                        $k => ['in', $result['ad_ids']]
                    ];
                    $adData = self::getModAd($game)->field('adduser')->where($where)->group('adduser')->select();
                    $adData = $adData ? collection($adData)->toArray() : [];
                    $adUser = array_column($adData, 'adduser');
                    self::getModGame()->where(['id' => $game['id']])->update(['ad_ids' => json_encode($result['ad_ids'])]);
                    $users = array_merge((array)$game['adduser'], (array)DingFormat::$mediaUser[$game['media_id']]);
                    foreach ($users as $user) {
                        DingFormat::setMsg(
                            $user,
                            Util::strf(
                                "游戏：%s\n其余配置：开始时间：%s 间隔时长：%s 总广告消耗：%s 单广告消耗：%s\n监控消耗：%s\n涉及用户：%s 涉及数量：%s",
                                $game['game_id'],
                                $configs['begin_time'],
                                $configs['interval_hr'],
                                $configs['cost_r'],
                                $configs['ad_cost_r'],
                                $result['cost_r'],
                                count($adUser),
                                count($result['ad_ids'])
                            )
                        );
                    }
                    DingFormat::send();
                } else {
                    self::debugs(self::$MSG[4], $game);
                }
            } catch (\Exception $e) {
                ibnerror("[ game.monitor({$game['id']}{$game['game_id']}).cost ]: {$e->getMessage()}");
                self::debugs($e->getTraceAsString(), $game);
            }
        }, function ($result, $extra) use ($result, $configs) {

        });
    }

    public static function handleConfigs($game) {
        $configs = self::getConfigs($game);
        foreach ($configs as $i => $config1) {
            foreach ($config1 as $ii => $config2) {

            }
        }
    }

    /**
     * @param $twoConfig
     * @param $result
     *
     * @return bool
     * @throws \Exception
     */
    public static function compare($twoConfig, $result) {
        $cd = trim($twoConfig['cd']);
        $k = trim($twoConfig['k']);
        $v = trim($twoConfig['v']);
        if ($cd === '>') {
            return (float)$result[$k] > (float)$v;
        } else if ($cd === '<') {
            return (float)$result[$k] < (float)$v;
        } else if ($cd === 'between') {
            return ((float)$result[$k] > (float)$v) && ((float)$result[$k] < (float)$twoConfig['v1']);
        } else {
            throw new \Exception('【MonitorStrategy-compare】未知操作符 ');
        }
    }

    /**
     * @param string $op & or
     * @param        $flag1
     * @param        $flag2
     *
     * @return bool
     * @throws \Exception
     */
    public static function get_flag($op, $flag1, $flag2) {
        $op = trim($op);
        if ($op === 'and') {
            return $flag1 && $flag2;
        } elseif ($op === 'or') {
            return $flag1 || $flag2;
        } else {
            return $flag2;
        }
    }
}
