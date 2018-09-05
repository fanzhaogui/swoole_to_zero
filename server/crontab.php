<?php
/**
 * Swoole Crontab
 *
 * swooler_timer_tick 函数相当于setInterval，是持续触发的
 * swoole_timer_after 函数相当于setTimeout, 触发一次
 * swoole_timer_tick 和 swoole_timer_after 函数会返回一个整数，表示定时器的ID
 * 可以使用swoole_timer_clear清除此定时器，参数为定时器的ID
 */

class Ws
{

    const HOST = '0.0.0.0';
    CONST PORT = 9501;

    public $ws = NULL;

    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);

        // 为设置前，参考代码底部注释
        // 设置之后，直接访问 http://tp51.andy.3qma.com:9501/ws_client.html
        $this->ws->set([
            'worker_num' => 2,
        ]);

        // 监听消息事件
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);

        $this->ws->on('close', [$this, "onClose"]);
        $this->ws->start();
    }

    /**
     * 监听websocket连接打开事件
     * @param $serv
     * @param $request
     */
    public function onOpen($serv, $request)
    {
        // var_dump($request->fd, $request->get, $request->server);

        if($request->fd == 1) {
            swoole_timer_tick(2000, function ($timer_id) {
                echo "2s: timer_id:{$timer_id}\n";
            });
        }


        $serv->push($request->fd, "Hello World \n");
    }

    /**
     * 监听websocket消息事件
     * @param $serv
     * @param $frame
     */
    public function onMessage($serv, $frame)
    {
        echo "Message: {$frame->data}\n";

        swoole_timer_after(5000, function () use ($serv, $frame) {
            echo "5s-after \n";
            $serv->push($frame->fd, "server-time-after: 5s");
        });

        $serv->push($frame->fd, "server: {$frame->data}");
    }


    /**
     * @param $ser
     * @param $fd
     */
    public function onClose ($ser, $fd)
    {
        echo "client-{$fd} is closed\n";
    }


}

$obj = new Ws();