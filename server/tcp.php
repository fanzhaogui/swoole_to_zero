<?php

// netstat -anp | grep 9501 端口号
// kill  ---   干掉端口9501

//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("127.0.0.1", 9501);


// 设置
$serv->set([
    'worker_num' => 8, // worker 进程数  cpu 1-4倍
    'max_request' => 1000
]);


//监听连接进入事件
$serv->on('connect', function ($serv, $fd, $reactor_id) {
    echo "Client: {$reactor_id} -{$fd} Connect.\n";
});

//监听数据接收事件
$serv->on('receive', function ($serv, $fd, $reactor_id, $data) {
    $serv->send($fd, "Server:{$reactor_id} - {$fd} ".$data);
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start();


// 测试连接  telnet 127.0.0.1 9501

