<?php
return [
	// 服务器名称
	'SERVER_NAME' => "EasySwoole",
	'MAIN_SERVER' => [
		// 监听地址
		'LISTEN_ADDRESS' => '0.0.0.0',
		// 监听端口
		'PORT'           => 9501,
		'SERVER_TYPE'    => EASYSWOOLE_WEB_SERVER,
		//可选为 EASYSWOOLE_SERVER  EASYSWOOLE_WEB_SERVER EASYSWOOLE_WEB_SOCKET_SERVER,EASYSWOOLE_REDIS_SERVER
		// 该选项当为 SERVRE_TYPE 值为 TYPE_SERVER 时有效
		'SOCK_TYPE'      => SWOOLE_TCP,
		// 默认 Server 运行模式
		'RUN_MODEL'      => SWOOLE_PROCESS,
		// Swoole_Server 运行配置 （完整配置可见[Swoole文档](https://wiki.swoole.com/wiki/page/274.html)）
		'SETTING'        => [
			// 运行 worker 的数量
			'worker_num'    => 8,
			// 设置异步重启开关。设置为true时，将启用异步安全重启特性，Worker进程会等待异步事件完成后再退出
			'reload_async'  => true,
			'max_wait_time' => 3,
		],
		'TASK'           => [
			'workerNum'     => 4,
			'maxRunningNum' => 128,
			'timeout'       => 15,
		],
	],
	// 临时文件存放的目录
	'TEMP_DIR'    => null,
	// 日志文件存放的目录
	'LOG_DIR'     => null,

	'MYSQL' => [
		'host'     => '127.0.0.1',
		'port'     => 3306,
		'user'     => 'dev',
		'password' => '3qma123456.',
		'database' => 'bearadmin_demo',
		'timeout'  => 5,
		'charset'  => 'utf8mb4',
	],

    'REDIS' => [
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'timeout'  => 5,
    ],

	'JWT' => [
		//token在header中的name
		'name'                   => 'token',
		//token加密使用的secret
		'secret'                 => '552ac90778a976c72f7f673db174df30',
		//颁发者
		'iss'                    => 'iss',
		//使用者
		'aud'                    => 'aud',
		//过期时间，以秒为单位，默认2小时。提示：感觉刷新麻烦的可以设置的大一些，比如10年20年之类的
		'ttl'                    => 7200,
		//刷新时间，以秒为单位，默认14天。提示：只有过期时间到了才会生效，所以把过期时间设置的很大的懒人就可以忽略了
		'refresh_ttl'            => 1209600,
		//是否自动刷新，开启后可自动刷新token，附在header中返回，name为`Authorization`,字段为`Bearer `+$token
		'auto_refresh'           => true,
		//黑名单宽限期，以秒为单位，首次token刷新之后在此时间内原token可以继续访问
		'blacklist_grace_period' => 60
	],

    ## socket
    // 当前的域名
    'HOST'           => 'http://127.0.0.1:9501',
    'WEBSOCKET_HOST' => 'ws://127.0.0.1:9501',
];
