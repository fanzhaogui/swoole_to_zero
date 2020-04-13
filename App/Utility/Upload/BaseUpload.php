<?php
/**
 * User: Andy
 * Date: 2020/4/13
 * Time: 0:16
 */

namespace App\Utility\Upload;

/**
 * 上传文件-基类
 *
 * @package App\Utility\Upload
 */
class BaseUpload
{

	/**
	 * @var $request \EasySwoole\Http\Request
	 */
	public $request;

	/**
	 * 上传的文件类型 file -type
	 * @var string $type
	 */
	public $type;


	/**
	 * 子类处理的文件类型
	 * @var string
	 */
	public $fileType;

	public $clientMediaType;

	/**
	 * 允许上传的文件类型
	 * 
	 * @var array $allowedFileExtTypes
	 */
	public $allowedFileExtTypes = [
		'mp4',
	];

	/**
	 * 允许的最大尺寸
	 *
	 * @var int $maxSize
	 */
	public $maxSize = 1024;

	public function __construct(\EasySwoole\Http\Request $request)
	{
		$this->request = $request;
		/*
		Array
		(
			[video] => Array
				(
					[name] => 1.mp4
					[type] => video/mp4
					[tmp_name] => /tmp/swoole.upfile.UuIUhs
					[error] => 0
					[size] => 568151
				)

		)
		*/
		$files = $this->request->getSwooleRequest()->files;

		$types = array_keys($files);
		/*
		Array
		(
			[0] => video
		)
		*/
		$this->type = $types[0] ?? '';


	}

	/**
	 * 执行上传
	 */
	public function upload()
	{
		if ($this->type != $this->fileType) {
			return false;
		}

		$videos = $this->request->getUploadedFile('file');
	}


	public function getFile($fileName)
	{
		$pathinfo = pathinfo($fileName);
	}


	/**
	 * 文件类型检测
	 *
	 * @return bool
	 */
	public function checkMediaType()
	{
		$clientMediaType = explode("/", $this->clientMediaType);
		$clientMediaType = $clientMediaType[1] ?? '';
		if (empty($clientMediaType) || !in_array($clientMediaType, $this->allowedFileExtTypes)) {

			throw new \InvalidArgumentException("上传{$this->type}文件不合法");
		}

		return true;
	}


	/**
	 * 文件上传的大小检测
	 *
	 * @return bool
	 */
	public function checkSize()
	{
		if (empty($this->maxSize)) {
			return false;
		}

		// todo


		return true;
	}
}