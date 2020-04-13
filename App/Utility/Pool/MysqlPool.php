<?php
/**
 * User: Andy
 * Date: 2020/4/10
 * Time: 22:50
 */

namespace App\Utility\Pool;


use EasySwoole\EasySwoole\Config;
use EasySwoole\Pool\AbstractPool;

class MysqlPool extends AbstractPool
{
	public function createObject()
	{
		$conf = Config::getInstance()->getConf('MYSQL');
		$dbConf = new \EasySwoole\Mysqli\Config($conf);
		return new MysqlPoolObject($dbConf);
	}
}