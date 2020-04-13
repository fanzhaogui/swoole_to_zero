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
class TaskOne extends AbstractCronTask
{
    #  *    *    *    *    *
    #  -    -    -    -    -
    #  |    |    |    |    |
    #  |    |    |    |    |
    #  |    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
    #  |    |    |    +---------- month (1 - 12)
    #  |    |    +--------------- day of month (1 - 31)
    #  |    +-------------------- hour (0 - 23)
    #  +------------------------- min (0 - 59)

    /**
     * @yearly                    每年一次 等同于(0 0 1 1 *)
     * @annually                  每年一次 等同于(0 0 1 1 *)
     * @monthly                   每月一次 等同于(0 0 1 * *)
     * @weekly                    每周一次 等同于(0 0 * * 0)
     * @daily                     每日一次 等同于(0 0 * * *)
     * @hourly                    每小时一次 等同于(0 * * * *)
     */



    public static function getRule(): string
    {
        // 定时周期 - 每小时
        return '@hourly';
    }


    public static function getTaskName(): string
    {
        // 任务名称
        return 'taskOne';
    }

    public function onException(\Throwable $throwable, int $taskId, int $workerIndex)
    {
        // 处理异常
    }

    public function run(int $taskId, int $workerIndex)
    {
        // 定时任务的逻辑
        var_dump('run once per hour');
    }
}