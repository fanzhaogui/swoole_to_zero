<?php
/**
 * User: Andy
 * Date: 2020/3/31
 * Time: 0:05
 */

/*报错： 找不到该函数*/

$file = __DIR__ . '/1.txt';
swoole_async_readfile($file, function ($filename, $fileContent) {
	echo "filename : ", $filename, PHP_EOL;
	echo "filecontent : ", $fileContent, PHP_EOL;
});

echo "start php" . PHP_EOL;