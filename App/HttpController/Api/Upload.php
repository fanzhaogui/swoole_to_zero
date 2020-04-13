<?php
/**
 * User: Andy
 * Date: 2020/4/11
 * Time: 17:46
 */

namespace App\HttpController\Api;


use App\Utility\Upload\Video;
use EasySwoole\Http\Message\Status;

class Upload extends ApiBase
{

	/**
	 * 文件上传 v1
	 *
	 * @method post
	 * @url /Api/Upload/file
	 * @return bool
	 */
	public function file()
	{
		/**@var $videos \EasySwoole\Http\Message\UploadFile*/
		$videos = $this->request()->getUploadedFile('video');
		return $this->writeJson(Status::CODE_OK, '', 'success');
		$savePath = '/website/video/';

		$videoName = '2.mp4';
		$flag = $videos->moveTo($savePath . $videoName);


		$videos->getClientFilename();
		$videos->getClientMediaType();

		if (!$flag) {
			// errr
			return $this->writeJson(Status::CODE_EXPECTATION_FAILED, '', 'fail: ' . $videos->getError());
		}

		$data = [
			'flat' => $flag,
			'url' => $savePath . $videoName,
		];
		return $this->writeJson(Status::CODE_OK, $data, 'success');
	}


	/**
	 * 文件上传 v1
	 *
	 * @method post
	 * @url /Api/Upload/videofile
	 * @return bool
	 */
	public function videofile()
	{
		try {

			$video = new Video($this->request());
			$rs = $video->upload();
			if (!$rs) {
				return $this->writeJson(401, '', '上传失败！');
			}
			return $this->writeJson(200, ['url' => $rs], '上传成功！');

		} catch (\InvalidArgumentException $e) {
			return $this->writeJson(402, '', $e->getMessage());
		} catch (\Throwable $e) {
			return $this->writeJson(403, '', '上传失败！');
		}
	}
}