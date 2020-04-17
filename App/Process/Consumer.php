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
        $this->addTick(5000, function () {
            if (!$this->isRun) {
                $this->isRun = true;
                /**@var $redis \Redis*/
                // $redis = \EasySwoole\Pool\Manager::getInstance()->get('redis')->getObj();

				$config = new \EasySwoole\Redis\Config\RedisConfig([
					'host' => '127.0.0.1',
					'port' => '6379',
					'serialize' => \EasySwoole\Redis\Config\RedisConfig::SERIALIZE_NONE,
				]);
				$redis = new \EasySwoole\Redis\Redis($config);

                while (true) {
                    try {
						$rs = $redis->lPop('copy_log');
                        // do you task
						if (!$rs) {
							break;
						}

						// TODO 考虑使用协程，将获取的数据接收后，写入数据库

						error_log( $this->getProcessName() . 'task run check: ' .$rs . "\r\n", 3, 'process.log');
                    } catch (\Throwable $e) {
                        break;
                    }
                }
                $this->isRun = false;
            }
            // var_dump($this->getProcessName() . 'task run check');
        });
    }






}