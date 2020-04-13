<?php
/**
 * 显示html静态页面
 */


$http = new swoole_http_server("0.0.0.0", 9503);

$http->set([
    'enable_static_handler' => true,
    'document_root' => '/home/wwwroot/swoole/web', //设置静态资源目录
]);

// 当能在静态资源匹配到时，不会走下面的事件
$http->on('request', function ($request, $response) {
    print_r($request->get);
    $response->end("<h1>Hello Swoole. #" . rand(1000, 9999) . "</h1>");
});


$http->start();