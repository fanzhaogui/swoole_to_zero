<?php

namespace App\Model\User;

use EasySwoole\ORM\AbstractModel;

class UserModel extends AbstractModel
{

	protected $tableName = 'sw_user_list';

	protected $primaryKey = 'userId';

	/**
	 * 获取列表
	 */
	public function getAll(int $page = 1, string $keyword = null, int $pageSize = 10): array
	{
		$where = [];
		if ($keyword) {
			$where['userAcount'] = ['%' . $keyword . '%', 'like'];
		}

		$list = $this->limit($pageSize * ($page - 1), $pageSize)
			->order($this->primaryKey, 'desc')
			->withTotalCount()
			->all($where);

		$total = $this->lastQueryResult()->getTotalCount();

		return ['list' => $list, 'count' => $total];
	}

	// 登录
	public function login():?UserModel
	{
		$info = $this->get([
			'userAccount'  => $this->userAccount,
			'userPassword' => $this->userPassword,
		]);

		return $info;
	}

	// 通过手机号码获取信息
	public function getOneByPhone($field = '*'):?UserModel
	{
		$info = $this->field($field)->get(['userPhone' => $this->userPone]);

		return $info;
	}

	// 通过session获取用户信息
	public function getOneBySession($field = '*'):?UserModel
	{
		$info = $this->field($field)
			->get(['userSession' => $this->userSession]);

		return $info;
	}

	// 登出
	public function logout()
	{
		return $this->update(['userSession' => '']);
	}
}
