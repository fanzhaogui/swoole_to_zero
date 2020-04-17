<?php
/**
 * 缓存 ：  Redis
 * User: Andy
 * Date: 2020/4/12
 * Time: 0:37
 */

require_once '../vendor/autoload.php';


go(function () {
	$config = new \EasySwoole\Redis\Config\RedisConfig([
		'host' => '127.0.0.1',
		'port' => '6379',
		'serialize' => \EasySwoole\Redis\Config\RedisConfig::SERIALIZE_NONE,
	]);
	$redis = new \EasySwoole\Redis\Redis($config);

	$key = 'test';
	var_dump($redis->set($key, 'test', 1000));
	var_dump($redis->get($key));

	$key = 'list';
	var_dump($redis->rPush($key, '2'));
	var_dump($redis->lPop($key));
});