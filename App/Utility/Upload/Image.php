<?php
/**
 * User: Andy
 * Date: 2020/4/13
 * Time: 0:21
 */

namespace App\Utility\Upload;


/**
 * 图片
 *
 * @package App\Utility\Upload
 */
class Image extends BaseUpload
{

	/**
	 * 文件类型
	 *
	 * @var string
	 */
	public $fileType = 'image';

	/**
	 * 允许上传的文件类型
	 *
	 * @var array $allowedFileExtTypes
	 */
	public $allowedFileExtTypes = [
		'jpeg',
		'png',
	];

	/**
	 * 允许的最大尺寸
	 *
	 * @var int $maxSize
	 */
	public $maxSize = 2048;

}