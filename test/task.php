<?php
/**
 * 异步任务
 *
 * User: fanzhaogui
 * Date: 2020/4/14
 * Time: 17:34
 */

require_once '../vendor/autoload.php';

use EasySwoole\Task\Config;
use EasySwoole\Task\Task;
use Swoole\Coroutine as co;

$config = new Config();
$task = new Task($config);

// 添加swoole服务
$http = new swoole_http_server('0.0.0.0', 9502);

// 注入swoole服务，进行创建task进程
$task->attachToServer($http);

// 在onrequest事件中调用task
$http->on("request", function (Swoole\Http\Request $request, Swoole\Http\Response $response) use ($task) {
    if (isset($request->get['sync'])) {
        // 同步调用
        $ret = $task->sync(function ($taskId, $workerIndex) {
            return "{$taskId} - {$workerIndex}";
        });

        $response->end("sync result ". $ret);
    } else if  (isset($request->get['status'])) {
        var_dump($task->status());
    } else {
        // 异步调用 task
        $id = $task->async(function ($taskId, $workerIndex) {
            co::sleep(1);
            var_dump("async id {$taskId} task run");
        });
        $response->end('async id {$id}');
    }
});