<?php

// 测试连接  telnet 127.0.0.1 9501
/**
 * 编写客户端 tcp
 */

// 连接 swoole tcp 服务

// 创建 客户端 swoole

// 判断是否连接成功

// php  cli 常量 STDOUT  STDIN   fwrite  fgets

// 发送消息给 tcp server 服务器

// 接收来自 server 的数据

// ps aft | grep tcp.php 查看进程 ， 对应 tcp server set 的进程数

/*

$serv->set([
    'worker_num' => 8, // worker 进程数  cpu 1-4倍
    'max_request' => 1000
]);

30446 pts/5    S+     0:00  \_ grep --color=auto tcp.php
29262 pts/0    Sl+    0:00  \_ php tcp.php
29264 pts/0    S+     0:00      \_ php tcp.php
29266 pts/0    S+     0:00          \_ php tcp.php
29267 pts/0    S+     0:00          \_ php tcp.php
29268 pts/0    S+     0:00          \_ php tcp.php
29269 pts/0    S+     0:00          \_ php tcp.php
29270 pts/0    S+     0:00          \_ php tcp.php
29271 pts/0    S+     0:00          \_ php tcp.php
29272 pts/0    S+     0:00          \_ php tcp.php
29273 pts/0    S+     0:00          \_ php tcp.php

*/

// TODO 如何实现平缓重启？？

$client = new swoole_client(SWOOLE_SOCK_TCP);

if(!$client->connect("127.0.0.1", 9501)) {
    echo "connection fail";
    exit;
}

fwrite(STDOUT, "please enter message: ");

$msg = trim(fgets(STDIN));

$client->send($msg);

$result = $client->recv();

echo "client receice messge: ". $result;