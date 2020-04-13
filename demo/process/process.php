<?php
/**
 * User: Andy
 * Date: 2020/3/31
 * Time: 1:05
 */

$process = new swoole_process(function (swoole_process $pro) {

	// echo "123123"; // 当第二参数为true时，不会输出到终端
//}, true);

	// php redis.php
	/*bin php.file*/
	$pro->exec('/usr/local/php/bin/php', [__DIR__ . '/../server/http_server.php']);

}, false);

$pid = $process->start();

echo $pid . PHP_EOL;


swoole_process::wait(); // 回收子进程