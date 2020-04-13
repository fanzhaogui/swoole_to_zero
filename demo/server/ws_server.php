<?php
/**
 * User: Andy
 * Date: 2019/5/7
 * Time: 17:40
 */

$server = new swoole_websocket_server("0.0.0.0", 9501);

// $server->set([]);
/*
$server->set([
    'enable_static_handler' => true,
    'document_root' => '/home/wwwroot/swoole/web', //设置静态资源目录
]);
*/

// 监听websocket连接打开事件
$server->on('open', 'onOpen');
function onOpen(swoole_websocket_server $server, $request) {
    print_r($request->fd);
}

// 监听ws消息事件
$server->on('message', function (swoole_websocket_server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "qcloud server");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();