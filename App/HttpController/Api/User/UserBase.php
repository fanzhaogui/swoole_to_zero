<?php
/**
 * User: Andy
 * Date: 2020/4/8
 * Time: 22:04
 */

namespace App\HttpController\Api\User;

use App\HttpController\Api\ApiBase;
use App\Model\User\UserModel;
use EasySwoole\Http\Message\Status;

class UserBase extends ApiBase
{

	/**
	 * @var $who UserModel
	 */
	protected $who;

	// session的cookie头
	protected $sessionKey = 'userSession';

	// 白名单
	protected $whiteList = ['login', 'register'];

	public function onRequest(?string $action): ?bool
	{
		if (parent::onRequest($action)) {
			// 白名单判断
			if (in_array($action, $this->whiteList)) {
				return true;
			}

			// 获取登录信息
			if (!$data = $this->getWho()) {
				$this->writeJson(Status::CODE_UNAUTHORIZED, '', '登录已过期');
				return false;
			}

			// 刷新cookie存活
			$this->response()
				->setCookie($this->sessionKey, $data->getOneBySession(), time() + 3600);

			return true;
		}

		return false;
	}


	public function getWho(): ?UserModel
	{
		if ($this->who instanceof UserModel) {
			return $this->who;
		}

		$sessionKey = $this->getUserSessionKey();
		if (empty($sessionKey)) {
			return null;
		}

		$userModel              = new UserModel();
		$userModel->userSession = $sessionKey;
		// 赋值给成员属性，用成员属性来取值
		$this->who = $userModel->getOneBySession();

		return $this->who;
	}


	/** 获取session key
	 * @return array|mixed|null
	 */
	protected function getUserSessionKey()
	{
		$sessionKey = $this->request()->getRequestParam($this->sessionKey);
		if (empty($sessionKey)) {
			$sessionKey = $this->request()->getCookieParams($this->sessionKey);
		}

		return $sessionKey;
	}
}