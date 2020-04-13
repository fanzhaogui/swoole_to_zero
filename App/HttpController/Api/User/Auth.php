<?php
/**
 * User: Andy
 * Date: 2020/4/8
 * Time: 22:13
 */

namespace App\HttpController\Api\User;


use App\Model\User\UserModel;
use EasySwoole\Http\Message\Status;


class Auth extends UserBase
{
	protected $whiteList = ['login', 'register'];

	// 登录
	public function login()
	{
		$param = $this->request()->getRequestParam();
		$model = new UserModel();
		$model->userAccount = $param['userAccount'];
		$model->userPassword = md5($param['userPassword']);
		$userInfo = $model->login();

		if ($userInfo) {
			// 用户session
			$sessionHash = md5(time()  . $userInfo->userId);
			$userInfo->update([
				'lastLoginIp' => $this->clientRealIP(),
				'lastLoginTime' => time(),
				'userSession' => $sessionHash,
			]);

			$rs = $userInfo->toArray();
			unset($rs['userPassword']);
			$rs['userSession'] = $sessionHash;
			$this->response()->setCookie($this->sessionKey, $sessionHash, time() + 3600, '/');

			return $this->writeJson(Status::CODE_OK, $rs);
		} else {
			return $this->writeJson(Status::CODE_BAD_REQUEST, '', '密码错误');
		}
	}

	// 登出
	public function logout()
	{
		$sessionKey = $this->getUserSessionKey();
		if (empty($sessionKey)) {
			$this->writeJson(Status::CODE_UNAUTHORIZED, '', '尚未登入');
			return false;
		}

		$result = $this->getWho()->logout();
		if ($result) {
			return $this->writeJson(Status::CODE_OK, '', '登出成功');
		} else {
			return $this->writeJson(Status::CODE_UNAUTHORIZED, '', 'fail');
		}
	}

	// 获取用户信息
	public function getInfo()
	{
		return $this->writeJson(200, $this->getWho(), 'success');
	}
}