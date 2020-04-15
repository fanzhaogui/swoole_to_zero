<?php
/**
 * Created by PhpStorm.
 * User: fanzhaogui
 * Date: 2020/4/14
 * Time: 18:39
 */

namespace App\Process;


use EasySwoole\Component\Process\AbstractProcess;
use Swoole\Coroutine;
use Swoole\Process;

class ProcessOne extends AbstractProcess
{
    private $data = [];

    // 当进程启动后，会执行的回调
    public function run($arg)
    {
        // 接收参数
        $size = $arg['size'];
        // 处理数据
        go(function () use ($size) {
            while (true) {
                echo $this->getProcessName() . " :run";
                $this->data[] = 'EasySwooole';
                if (count($this->data) > $size) {
                    echo "报警邮件提示";
                }
                var_dump(count($this->data));
                Coroutine::sleep(rand(1, 3));
            }
        });
    }


    public function onPipeReadable(Process $process)
    {
        $command = $process->read();
        switch ($command) {
            case 'clear' :
                $this->data = [];
                break;
            default :
                echo "command not exists    ";
                break;
        }

        echo __FUNCTION__ . PHP_EOL;
    }

    public function onShutDown()
    {
        parent::onShutDown();
    }


    public function onException(\Throwable $throwable, ...$args)
    {
        parent::onException($throwable, $args);
    }
}