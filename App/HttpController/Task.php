<?php
/**
 * Created by PhpStorm.
 * User: fanzhaogui
 * Date: 2020/4/21
 * Time: 10:05
 */

namespace App\HttpController;

use App\Task\TestTask;
use EasySwoole\EasySwoole\Task\TaskManager;
use Swoole\Coroutine;

/**
 * 异步闭包任务
 * 异步模板任务
 * @package App\HttpController
 */
class Task extends BaseController
{

    public function asyncTemp()
    {
        ## 异步模板任务 ##
        $task = TaskManager::getInstance();
        // 异步
        $task->async(new TestTask(['name'=>'zhangsan']));
        // 同步任务
        $data =  $task->sync(new TestTask(['name'=>'lisi']));
        return $this->response()->write($data);
    }

    // 异步任务
    public function async()
    {
        TaskManager::getInstance()->async($this->asyncStart(), $this->asyncFinish());

        return $this->writeJson(200, ['time' => date('Y-m-d H:i:s')], 'success');
    }

    // 异步任务开始
    private function asyncStart()
    {
        return function () {
            echo date('Y-m-d H:i:s') , "异步任务开始运行 " . PHP_EOL;
            // 模拟耗时的操作
            Coroutine::sleep(rand(3, 10));
        };
    }

    // 异步任务结束
    private function asyncFinish()
    {
        return function () {
            echo date('Y-m-d H:i:s') , "异步任务执行完成" . PHP_EOL;
        };
    }
}