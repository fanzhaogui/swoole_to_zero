<?php
/**
 * Created by PhpStorm.
 * User: fanzhaogui
 * Date: 2020/4/10
 * Time: 17:03
 */

namespace App\Process;


use EasySwoole\Component\Process\AbstractProcess;
use Swoole\Process;

/**
 * 实现消费进程逻辑
 *
 * @package App\Process
 */
class Consumer extends AbstractProcess
{
    private $isRun = false;

    public  function run($arg)
    {
        /**
         * 消费redis中的队列数据
         * 定时500ms检测有没有任务，有的话就while死循环执行
         */
        $this->addTick(500, function () {
            if (!$this->isRun) {
                $this->isRun = true;
                /**@var $redis \Redis*/
                $redis = \EasySwoole\Pool\Manager::getInstance()->get('redis')->getObj();

                $redis->lPop('copy_log');

                while (true) {
                    try {
                        // do you task
                    } catch (\Throwable $e) {
                        break;
                    }
                }
                $this->isRun = false;
            }
            var_dump($this->getProcessName() . 'task run check');
        });
    }






}