<?php
/**
 * User: Andy
 * Date: 2020/4/23
 * Time: 22:55
 */

/**
 * 配置操作类 EasySwoole\Config
 *
 * ** 需要注意的是 由于进程隔离的原因 在Server启动之后，动态新增修改的配置项，只对执行操作的进程生效，如果
 * 需要全局共享配置需要自己进行扩展**
 */
require_once '../vendor/autoload.php';

$instance = \EasySwoole\EasySwoole\Config::getInstance();

// 获取配置 按层级用点号分隔
$instance->getConf('MAIN_SERVER.SETTING.task_worker_num');

// 设置配置 按层级用点号分隔
$instance->setConf('DATABASE.host', 'localhost');

// 获取全部配置
$conf = $instance->getConf();

// 用一个数组覆盖当前配置项
$conf['DATABASE'] = [
	'host' => '127.0.0.1',
	'port' => '13306',
];

$instance->load($conf);