<?php


namespace App\HttpController;


use App\Task\TestTask;
use EasySwoole\EasySwoole\Task\TaskManager;
use EasySwoole\Http\AbstractInterface\Controller;
use Swoole\Coroutine;

class Index extends BaseController
{

    function index()
    {
        ## 异步模板任务 ##
        $task = TaskManager::getInstance();
        // 异步
        $task->async(new TestTask(['name'=>'zhangsan']));
        // 同步任务
        $data =  $task->sync(new TestTask(['name'=>'lisi']));
        return $this->response()->write($data);


        ## 异步任务 ##
        $task = TaskManager::getInstance();
        $task->async(function () {
            Coroutine::sleep(1);
            echo "异步调用task1\n";
        });

        $data = $task->sync(function () {
            echo "同步调用task1\n";
            return "可以返回调用结果\n";
        });

        $this->request()->withHeader('Content-Type', 'text/html;charset=utf-8');
        return $this->response()->write($data);

        #$file = EASYSWOOLE_ROOT.'/vendor/easyswoole/easyswoole/src/Resource/Http/welcome.html';
        #if(!is_file($file)){
        #    $file = EASYSWOOLE_ROOT.'/src/Resource/Http/welcome.html';
        #}
        #$this->response()->write(file_get_contents($file));

		$data = [
			'id' => 1,
			'name' => '张三',
			'params' => $this->request()->getRequestParam(),
		];
		return $this->writeJson(200, $data);
        $this->response()->write("Hello World!");
    }

    protected function actionNotFound(?string $action)
    {
        $this->response()->withStatus(404);
        $file = EASYSWOOLE_ROOT.'/vendor/easyswoole/easyswoole/src/Resource/Http/404.html';
        if(!is_file($file)){
            $file = EASYSWOOLE_ROOT.'/src/Resource/Http/404.html';
        }
        $this->response()->write(file_get_contents($file));
    }
}
