<?php
/**
 * Swoole WebSocket
 *
 *  # 解决 HTTP的通信只能由客户端发起
 *
 *  websock 协议是基于tcp的一种新的网络协议，它实现了浏览器与服务器全双工 full-duplex 通信
 * 允许服务器主动发送信息给客户端
 *
 *  1. 建立在 tcp 协议之上
 *  2. 性能开销小通信高效
 *  3. 客户端可以与任意服务器通信
 *  4. 协议标识符 wx wss
 *  5. 持久化网络通信协议
 *
 */

$server = new swoole_websocket_server("0.0.0.0", 9501);

// 为设置前，参考代码底部注释
// 设置之后，直接访问 http://tp51.andy.3qma.com:9501/ws_client.html
$server->set([
    'enable_static_handler' => true,
    'document_root' => '/home/wwwroot/tp51.andy.3qma.com/view'
]);

// 方式一
/*$server->on('open', function (swoole_websocket_server $server, $request) {
    echo "server: handshake success with fd{$request->fd}\n";
});*/

// 方式二
$server->on('open', "onOpen");
function onOpen($ser, $request) {
    print_r ("client fd : ".$request->fd."\r\n");
}

// 监听消息事件
$server->on('message', function (swoole_websocket_server $server, $frame) {

    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";

    // 给客户端发送数据
    $server->push($frame->fd, "this is server");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();

/**
 * 1. 通过  http server 设置可访问的 html
 * 2. 在html中websocket访问的 websocket server 中的内容
 */

