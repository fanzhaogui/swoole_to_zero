<?php

namespace EasySwoole\EasySwoole;


use App\Process\Consumer;
use App\Process\ProcessOne;
use App\Utility\Pool\MysqlPool;
use App\Utility\Pool\RedisPool;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\ORM\Db\Connection;
use EasySwoole\ORM\DbManager;
use EasySwoole\Pool\Manager;

class EasySwooleEvent implements Event
{

	/**
	 * @see https://github.com/HeKunTong/easyswoole3_demo
	 */
	public static function initialize()
	{
		// TODO: Implement initialize() method.
		date_default_timezone_set('Asia/Shanghai');

		// redis 连接池获取redis对象
		Manager::getInstance()
			->register(new RedisPool(new \EasySwoole\Pool\Config()), 'redis');
		Manager::getInstance()
			->register(new MysqlPool(new \EasySwoole\Pool\Config()), 'mysql');
		// 注销
		// \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redis);
	}

	public static function mainServerCreate(EventRegister $register)
	{
		// TODO: Implement mainServerCreate() method.

		// MySQL
		$config = new \EasySwoole\ORM\Db\Config(Config::getInstance()
			->getConf('MYSQL'));
		DbManager::getInstance()->addConnection(new Connection($config));

		// 注册消费进程
		$allNum = 3;
		for ($i = 0; $i < $allNum; $i++) {
			// ServerManager::getInstance()->addProcess(new Consumer("consumer_{$i}"));
		}

        /*** 进程注册 - start ***/
        $processConfig = new \EasySwoole\Component\Process\Config();
        $processConfig->setProcessName('testProcess');
        /**
         * 传递给进程的参数
         */
        $processConfig->setArg([
            'size' => 3,
        ]);

        $processOne = new ProcessOne($processConfig);
        try {
            # ServerManager::getInstance()->addProcess($processOne);
        } catch (\Throwable $e) {
            echo 'defined process err ： ' . $e->getMessage();
        }

        /*** 进程注册 - end ***/
	}

	public static function onRequest(Request $request, Response $response): bool
	{
		## process
        // $process = ServerManager::getInstance()->getProcess('testProcess');
        // $process->write('clear');

		return true;
	}

	public static function afterRequest(Request $request, Response $response): void
	{
		// TODO: Implement afterAction() method.
	}
}
