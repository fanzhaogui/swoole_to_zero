<?php
/**
 * Created by PhpStorm.
 * User: fanzhaogui
 * Date: 2020/4/10
 * Time: 17:48
 */

namespace App\Utility\Pool;


use EasySwoole\EasySwoole\Config;
use EasySwoole\Pool\AbstractPool;

class RedisPool extends AbstractPool
{
    // 创建
    public function createObject()
    {
        if (!extension_loaded('redis')) {
            throw new \BadFunctionCallException('not support redis extension');
        }

        $conf = Config::getInstance()->getConf('REDIS');
        $redis = new RedisObject();
        $connect = $redis->connect($conf['host'], $conf['port']);
        if ($connect) {
            if (!empty($conf['auth'])) {
                $redis->auth($conf['auth']);
            }
            return $redis;
        } else {
            return null;
        }
    }
}