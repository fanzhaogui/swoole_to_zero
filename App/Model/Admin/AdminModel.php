<?php

namespace App\Model\Admin;

use EasySwoole\ORM\AbstractModel;

class AdminModel extends AbstractModel
{
    protected $tableName = 'sw_admin_list';

    protected $primaryKey = 'adminId';
    
    /**
     * 获取列表
     */
    public function getAll(int $page = 1, string $keyword = null, int $pageSize = 10) :array
    {
	$where = [];
        if ($keyword) {
	    $where['adminAcount'] = ['%' . $keyword . '%', 'like'];
	}

	$list = $this->limit($pageSize * ($page - 1), $pageSize)->order($this->primaryKey, 'desc')
		->withTotalCount()->all($where);

	$total = $this->lastQueryResult()->getTotalCount();

	return ['list' => $list, 'count' => $total];
    }
    
    // 登录
    public function login() :?AdminModel
    {
	$info = $this->get([
	    'adminAccount' => $this->adminAccount,
	    'adminPassword' => $this->adminPassword
	]);
	return $info;
    }

    // 账号是否存在
    public function accountExist($field = '*') :?AdminModel
    {
	$info = $this->field($field)->get(['adminAccount' => $this->adminAccount]);
	return $info;
    }

    // 通过session获取用户信息
    public function getOneBySession($field = '*') :?AdminModel
    {
	$info = $this->field($field)->get(['adminSession' => $this->adminSession]);
 	return $info;
    }

    // 登出
    public function logout()
    {
	return $this->update(['adminSession' => '']);
    }
}
