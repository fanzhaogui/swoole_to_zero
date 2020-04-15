<?php
/**
 * Created by PhpStorm.
 * User: fanzhaogui
 * Date: 2020/4/15
 * Time: 16:36
 */

namespace App\Task;


use EasySwoole\Task\AbstractInterface\TaskInterface;

class BroadcastTask implements TaskInterface
{
    protected $taskData;


    public function __construct($data)
    {
        $this->taskData = $data;
    }

    public function run(int $taskId, int $workerIndex)
    {

    }

    public function onException(\Throwable $throwable, int $taskId, int $workerIndex)
    {

    }
}