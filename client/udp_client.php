<?php

// nc -u 127.0.0.1 9502
/**
 * 编写客户端 udp
 */

// 连接 swoole tcp 服务

// 创建 客户端 swoole

// 判断是否连接成功

// php  cli 常量 STDOUT  STDIN   fwrite  fgets

// 发送消息给 tcp server 服务器

// 接收来自 server 的数据

// ps aft | grep tcp.php 查看进程 ， 对应 tcp server set 的进程数

/*

默认 开启了 一个

*/

// TODO 如何实现平缓重启？？

$client = new swoole_client(SWOOLE_SOCK_UDP);

if(!$client->connect("127.0.0.1", 9502)) {
    echo "connection udp fail";
    exit;
}

fwrite(STDOUT, "please enter message: ");

$msg = trim(fgets(STDIN));

$client->send($msg);

$result = $client->recv();

echo "client receice messge: ". $result;