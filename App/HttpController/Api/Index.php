<?php
/**
 * User: Andy
 * Date: 2020/4/11
 * Time: 17:46
 */

namespace App\HttpController\Api;


use App\Model\Imooc\Video;
use EasySwoole\Http\Message\Status;

class Index extends ApiBase
{


	/**
	 * @url :9501/Api/Index/getVideo
	 * @return bool
	 */
	public function getVideo()
	{
		$model = new Video();
		// $data = $model->getAll();
		$params = $this->request()->getRequestParam();
		$model->id = $params['id'] ?? 1;
		$data = $model->getOneById();
		return $this->writeJson(Status::CODE_OK, $data, 'OK');
	}
}