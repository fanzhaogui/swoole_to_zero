<?php
/**
 * User: Andy
 * Date: 2020/4/23
 * Time: 23:01
 */

// DI注入配置
require_once '../vendor/autoload.php';

$di = \EasySwoole\Component\Di::getInstance();

// 配置错误处理回调
$di->set(\EasySwoole\EasySwoole\SysConst::ERROR_HANDLER, function () {

});

// 配置脚本结束回调
$di->set(\EasySwoole\EasySwoole\SysConst::SHUTDOWN_FUNCTION, function () {

});

// 配置控制器命名空间
$di->set(\EasySwoole\EasySwoole\SysConst::HTTP_CONTROLLER_NAMESPACE, 'App\HttpController');

// 配置http控制器最大解析层级
$di->set(\EasySwoole\EasySwoole\SysConst::HTTP_CONTROLLER_MAX_DEPTH, 5);

// 配置http控制器异常回调
$di->set(\EasySwoole\EasySwoole\SysConst::HTTP_EXCEPTION_HANDLER, function () {

});

// http控制器对象池最大数量
$di->set(\EasySwoole\EasySwoole\SysConst::HTTP_CONTROLLER_POOL_MAX_NUM, 5);