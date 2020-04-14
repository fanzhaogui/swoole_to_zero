<?php
/**
 * Created by PhpStorm.
 * User: fanzhaogui
 * Date: 2020/4/14
 * Time: 18:09
 */

namespace App\Task;


use EasySwoole\Task\AbstractInterface\TaskInterface;


/**
 * 投递模板任务
 *
 * @package App\Task
 */
class TestTask implements TaskInterface
{
    protected $data;

    /**
     * 通过构造函数，传入数据，获取该任务的数据
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * 执行本次任务
     *
     * @author: fanzhaogui
     * @param int $taskId
     * @param int $workerIndex
     */
    function run(int $taskId, int $workerIndex)
    {
        var_dump("templete task run : \n");
        var_dump($this->data);
        //只有同步调用才能返回数据
        return "return : ".$this->data['name'];
    }


    function onException(\Throwable $throwable, int $taskId, int $workerIndex)
    {
        // TODO: Implement onException() method.
        error_log("taskId:{$taskId} - workderIndex:{$workerIndex} - message : {$throwable->getMessage()} \n", 3, 'task_exception.log');
        return true;
    }


}