<?php
/**
 * User: Andy
 * Date: 2020/4/10
 * Time: 22:48
 */

namespace App\Utility\Pool;


use EasySwoole\Mysqli\Client;
use EasySwoole\Pool\ObjectInterface;

class MysqlPoolObject extends Client implements ObjectInterface
{
	function gc()
	{
		$this->reset();
		$this->close();
	}

	function objectRestore()
	{
		$this->reset();
	}

	function beforeUse():?bool
	{
		return $this->connect();
	}
}