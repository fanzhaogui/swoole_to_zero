<?php
/**
 * User: Andy
 * Date: 2019/5/8
 * Time: 18:09
 */

// ws 优化 基础类库
class Ws
{

	CONST HOST = "0.0.0.0";

	CONST PORT = 8812;

	public $ws = null;

	public function __construct()
	{
		$this->ws = new swoole_websocket_server(self::HOST, self::PORT);

		$this->ws->set([
			'work_num'        => 2,
			'task_worker_num' => 2,
		]);

		$this->ws->on('open', [$this, 'onOpen']);
		$this->ws->on('message', [$this, 'onMessage']);
		$this->ws->on('task', [$this, 'onTask']);
		$this->ws->on('finish', [$this, 'onFinish']);
		$this->ws->on('close', [$this, 'onClose']);

		echo "service start on " . self::HOST . ':' . self::PORT . PHP_EOL;

		$this->ws->start();
	}


	/**
	 * @param $ws
	 * @param $request
	 */
	public function onOpen($ws, $request)
	{
		var_dump($request->fd);

		if ($request->fd == 1) {
			// 每2秒执行一次，多次
			swoole_timer_tick(2000, function ($timeId) {
				echo "2s: timnerId : {$timeId}\n";
			});

		}
	}

	/**
	 * 消息事件
	 *
	 * @param $ws
	 * @param $frame
	 */
	public function onMessage($ws, $frame)
	{
		echo "server-push-message:{$frame->data}\n";

		// 5s钟之后执行，一次
		swoole_timer_after(5000, function () use ($ws, $frame) {
			echo "5s after\n";
			$ws->push($frame->fd, 'service-after 5s ');
		});

		$ws->push($frame->fd, "server-push: " . date("Y-m-d H:i:s"));
	}

	/**
	 * @param $ws
	 * @param $taskId
	 * @param $workId
	 * @param $data
	 */
	public function onTask($ws, $taskId, $workId, $data)
	{
		print_r($data);
		// 耗时场景
		sleep(10);

		return "on task finished"; // 告诉worker进程
	}

	/**
	 * @param $server
	 * @param $taskId
	 * @param $data onTaks return
	 */
	public function onFinish($server, $taskId, $data)
	{
		echo "taskId : {$taskId}\n";
		echo "finished task data: {$data}\n";
	}


	/**
	 * @param $ws
	 * @param $fd
	 */
	public function onClose($ws, $fd)
	{
		echo "closed id: {$fd} \n";
	}
}

$obj = new Ws();

