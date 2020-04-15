<?php
/**
 * User: Andy
 * Date: 2020/4/13
 * Time: 0:21
 */

namespace App\Utility\Upload;


/**
 * 上传视频
 *
 * @package App\Utility\Upload
 */
class Video extends BaseUpload
{

	/**
	 * 文件类型
	 *
	 * @var string
	 */
	public $fileType = 'video';

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
	 * 允许的最大尺寸
	 *
	 * @var int $maxSize
	 */
	public $maxSize = 1024;

}