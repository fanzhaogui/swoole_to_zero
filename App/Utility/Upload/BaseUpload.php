<?php
/**
 * User: Andy
 * Date: 2020/4/13
 * Time: 0:16
 */

namespace App\Utility\Upload;

use App\Utility\Utils;

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
	 * 文件名
	 *
	 * @var string
	 */
	public $file;

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

	/**
	 * 文件类型
	 * @var string
	 */
	public $clientMediaType;

	/**
	 * 允许上传的文件类型
	 * 
	 * @var array $allowedFileExtTypes
	 */
	public $allowedFileExtTypes = [
		'mp4',
		'x-flv',
	];

	/**
	 * 文件大小
	 *
	 * @var int $size
	 */
	public $size;

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
		var_dump($this->type, $this->fileType);
		if ($this->type != $this->fileType) {
			return false;
		}
		/**@var $videos \EasySwoole\Http\Message\UploadFile*/
		$videos = $this->request->getUploadedFile($this->type);

		$this->size = $videos->getSize();
		$this->checkSize();

		// video/mp4
		$this->clientMediaType = $videos->getClientMediaType();
		$this->checkMediaType();

		// 1.mp4
		$fileName = $videos->getClientFilename();
		$file = $this->getFile($fileName);

		$flag = $videos->moveTo($file);
		if (!$flag) {
			var_dump($videos->getError());
			return false;
		}

		return $this->file;
	}


	public function getFile($fileName)
	{
		/*
		array(4) {
		  ["dirname"]=>
		  string(1) "."
		  ["basename"]=>
		  string(5) "1.mp4"
		  ["extension"]=>
		  string(3) "mp4"
		  ["filename"]=>
		  string(1) "1"
		}
		*/
		$pathinfo = pathinfo($fileName);
		$extension = $pathinfo['extension'];

		$dirname = "/". $this->type ."/". date('Y') . "/" .date('m') . "/";
		$dir = EASYSWOOLE_ROOT . '/website' . $dirname;
		if (!is_dir($dir)) {
			mkdir($dir, 0755, true);
		}
		$basename = Utils::getFileKey($fileName) . "." . $extension;
		$this->file = $dirname . $basename;

		return $dir . $basename;
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
		if (empty($this->size)) {
			throw new \InvalidArgumentException("未找到文件！");
		}

		// todo
		if ($this->size > $this->maxSize) {

		}

		return true;
	}



}