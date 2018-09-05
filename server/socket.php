<?php

// 创建swbsocket服务器对象，监听0.0.0.0:9502端口
$server = new swoole_websocket_server("0.0.0.0", 9502);

// 给websocket对象添加属性user_c,值为空数组
$server->user_c = [];

// 方式一
$server->on('open', function (swoole_websocket_server $server, $request) {

    $server->user_c[] = $request->fd;

});

// 方式二
//$server->on('open', "onOpen");
//function onOpen($ser, $request) {
//    print_r ("client fd : ".$request->fd."\r\n");
//}

// 监听消息事件
$server->on('message', function (swoole_websocket_server $server, $frame) {

    echo  'from '.$frame->fd." : ". $frame->data .PHP_EOL;
    $msg = $frame->data .PHP_EOL;
    foreach ($server->user_c as $v) {
        $server->push($v, $msg);
    }

});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
    unset($ser->user_c[$fd - 1]); // 删除已断开的客户端
});

$server->start();

/**
 * 1. 通过  http server 设置可访问的 html
 * 2. 在html中websocket访问的 websocket server 中的内容
 */