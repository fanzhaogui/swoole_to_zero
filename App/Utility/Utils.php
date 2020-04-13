<?php
/**
 * User: Andy
 * Date: 2020/4/13
 * Time: 23:43
 */

namespace App\Utility;

/**
 * 通用类
 *
 * @package App\Utility
 */
class Utils
{

	/**
	 * 生成唯一的key
	 *
	 * @param $str
	 *
	 * @return bool|string
	 */
 	public static function getFileKey($str)
	{
		return substr(md5(self::makeRandomString()) . $str . time() . rand(0, 9999), 8, 16);
	}

	/**
	 * 生成随机字符串
	 *
	 * @param int $length
	 *
	 * @return string
	 */
	public static function makeRandomString($length = 1)
	{
		$str = '';
		$strPol = "ABCDEFGHIJKLMNOPQRSTUVWSYZ0123456789abcdefghijklmnopqrstuvwsyz";
		$max = strlen($strPol) - 1;
		for ($i = 0; $i < $length; $i ++) {
			$str .= $strPol[rand(0, $max)];
		}
		return $str;
	}
}