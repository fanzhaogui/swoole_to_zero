<?php

// swoole server

// http 协议

// request response

$http = new swoole_http_server("0.0.0.0", 8501);

$http->set([
    'enable_static_handler' => true,
    'document_root' => '/home/wwwroot/tp51.andy.3qma.com/view'
]);

$http->on('request', function ($request, $response) {
    // $_GET $_POST 无法获取
    //var_dump($request->get, $request->post);
    //$response->header("Content-Type", "text/html; charset=utf-8");

    // 在 end 中输出到浏览器
    $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
});

$http->start();

/**
 * 测试
 *
 *
 *
 * 1. 执行该文件
 *
 * 2. curl
 *
 *   http://curl 127.0.0.1:9501
 *
 * 3. 通过浏览器 直接访问
 *
 *   域名:9501
 *
 *  请查看 view 目录
 */

// TODO 平滑重启？ 更新代码？

