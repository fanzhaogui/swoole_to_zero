<?php
/**
 * User: Andy
 * Date: 2019/5/8
 * Time: 18:09
 */

// ws 优化 基础类库
class Ws
{
    CONST HOST = "0.0.0.0";
    CONST PORT = 8812;

    public $ws = null;

    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);

        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('close', [$this, 'onClose']);

        $this->ws->start();
    }


    /**
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request)
    {
        var_dump($request->fd);
    }

    /**
     * 消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame)
    {
        echo "server-push-message:{$frame->data}\n";
        $ws->push($frame->fd, "server-push: ".date("Y-m-d H:i:s"));
    }

    /**
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd)
    {
        echo "closed id: {$fd} \n";
    }
}

$obj = new Ws();

