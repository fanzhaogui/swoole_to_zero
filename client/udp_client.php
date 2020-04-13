<?php
/**
 * User: Andy
 * Date: 2019/4/25
 * Time: 12:17
 */

$client = new swoole_client(SWOOLE_SOCK_UDP);

if (!$client->connect('127.0.0.1', 9502, -1)) {
    exit("connect failed. Error: {$client->errCode}\n");
}


// php cli 常量

// 接收输入值
fwrite(STDOUT, "please write:");
$msg = trim(fgets(STDIN));
// 发送
$client->send($msg."\n");

// 接收来自服务器的返回
echo "From Server Data : ", $client->recv();

//

$client->close();
