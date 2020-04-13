<?php
/**
 * User: Andy
 * Date: 2019/4/25
 * Time: 13:07
 */


$http = new Swoole_Http_Server("127.0.0.1", 9503);


$http->on('request', function ($request, $response) {
    var_dump($request->get);
    // 可以用 $response 设置cookie等
    $response->end("<h1>Hello Swoole. #" . rand(1000, 9999) . "</h1>");
});


$http->start();