<?php


namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\Controller;

class Index extends BaseController
{

    function index()
    {
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
