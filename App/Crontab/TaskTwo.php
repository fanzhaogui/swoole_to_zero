<?php
/**
 * Created by PhpStorm.
 * User: fanzhaogui
 * Date: 2020/4/9
 * Time: 17:53
 */

namespace App\Crontab;


use EasySwoole\EasySwoole\Crontab\AbstractCronTask;

/**
 * 定时任务
 *
 * @package App\Crontab
 */
class TaskTwo extends AbstractCronTask
{
    /**
     * 定时任务的规则
     * @author: fanzhaogui
     * @return string
     */
    public static function getRule(): string
    {
        // 定时周期 - 每两分钟执行一次
        return '*/2 * * * *';
    }


    public static function getTaskName(): string
    {
        // 任务名称
        return 'TaskTwo';
    }

    public function onException(\Throwable $throwable, int $taskId, int $workerIndex)
    {
        // 处理异常
    }


    public function run(int $taskId, int $workerIndex)
    {
        // 定时任务的逻辑
        var_dump('run once every two minutes');
    }
}