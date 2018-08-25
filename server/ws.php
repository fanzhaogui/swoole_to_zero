<?php
/**
 * User: Andy
 * Date: 2018/8/25
 * Time: 17:50
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
            'enable_static_handler' => true,
            'document_root' => '/home/wwwroot/tp51.andy.3qma.com/view'
        ]);

        $this->ws->on('open', [$this, 'onOpen']);
        // 监听消息事件
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('close', [$this, "onClose"]);
        $this->ws->start();
    }

    /**
     * @param $ser
     * @param $fd
     */
    public function onClose ($ser, $fd)
    {
        echo "client {$fd} closed\n";
    }

    /**
     * @param $ser
     * @param $request
     */
    public function onOpen($ser, $request)
    {
        print_r ("client fd : ".$request->fd."\r\n");
    }

    /**
     * @param $server
     * @param $frame
     */
    public function onMessage($server, $frame)
    {
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";

        // 给客户端发送数据
        $server->push($frame->fd, "server push data".date("Y-m-d"));
    }

}

$obj = new Ws();