<?php
/**
 * 并发查询
 *
 * User: fanzhaogui
 * Date: 2020/4/14
 * Time: 10:18
 */

require_once '../vendor/autoload.php';


use Swoole\Coroutine as co;

go(function () {
    $chan = new co\Channel(12);


    $wait = new \EasySwoole\Component\WaitGroup();

    // 并发查询，将数据push到channel
    for ($i = 1; $i <= 12; $i ++) {
        $wait->add(); // ++
        go(function () use ($chan, $i, $wait) {
            // 模拟耗时操作
            $second = rand(1,3);
            co::sleep($second);
            $chan->push("第{$i}个月的数据!\n");
            $wait->done(); // --
        });
    }

    // 等待志雄完全
    $wait->wait();

    // 将channel中的数据拿出来输出到文件
    while (true) {
        if ($chan->isEmpty()) {
            break;
        }
        $res = $chan->pop();
        error_log($res . PHP_EOL, 3, '../Log/channel.log');
    }

    error_log('---------end---------' . PHP_EOL, 3, '../Log/channel.log');
});