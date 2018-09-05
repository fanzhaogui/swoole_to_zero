<?php
/**
 * Swoole Task
 *
 *  使用场景：
 *    执行耗时的操作： 发送邮件，广播等
 *
 *    onTask onFinish 设置task_worker_num
 */

class Ws
{

    const HOST = '0.0.0.0';
    CONST PORT = 9501;

    public $ws = NULL;

    public function __construct()
    {
        $this->ws = new swoole_server(self::HOST, self::PORT);

        // 为设置前，参考代码底部注释
        // 设置之后，直接访问 http://tp51.andy.3qma.com:9501/ws_client.html
        $this->ws->set([
            'worker_num' => 2,
            'task_worker_num' => 2,
        ]);

        // 监听消息事件
        $this->ws->on('receive', [$this, 'onReceive']);
        $this->ws->on('task', [$this, 'onTask']);
        $this->ws->on('finish', [$this, 'onFinish']);


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
     * @param $server
     * @param $frame
     */
    public function onReceive($serv, $fd, $from_id, $data)
    {
        echo "接收数据" . $data . "\n";
        $data = trim($data);
        sleep(10);
        $task_id = $serv->task($data, 0);
        $serv->send($fd, "分发任务，任务id为$task_id\n");
    }

    /**
     * 任务
     * @param $srv
     * @param $taskId
     * @param $workId
     * @param $data
     */
    public function onTask($serv, $task_id, $workId, $data)
    {
        echo "Tasker进程接收到数据";
        echo "#{$serv->worker_id}\tonTask: [PID={$serv->worker_pid}]: task_id=$task_id, data_len=".strlen($data).".".PHP_EOL;
        $serv->finish($data);
    }

    /**
     * 完成 onTask 必须作用域finish函数
     *
     * @param $data string
     */
    public function onFinish($serv, $task_id, $data)
    {
        echo "Task#$task_id finished, data_len=".strlen($data).PHP_EOL;
    }
}

$obj = new Ws();