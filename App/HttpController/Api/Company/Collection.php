<?php
/**
 * 数据收集
 * User: Andy
 * Date: 2020/4/8
 * Time: 22:13
 */

namespace App\HttpController\Api\Company;


use App\Process\ProcessOne;
use EasySwoole\Component\Process\Config;
use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\Http\Message\Status;


class Collection extends CompanyBase
{
	protected $whiteList = ['copy', 'visit'];

	/**
	 * 复制
	 *
	 * @url /Api/Company/Collection/copy
	 * @return bool
	 */
	public function copy()
	{
		$param = $this->request()->getRequestParam();

		$uri = $this->request()->getUri();

		return $this->writeJson(Status::CODE_OK, $this->jwtData, $this->companyId);

		if ($param) {

			return $this->writeJson(Status::CODE_OK, $this->jwtData, $this->companyId);
		} else {
			return $this->writeJson(Status::CODE_BAD_REQUEST, '', '密码错误');
		}
	}

    /**
     * 访问记录
     *
     * @author: fanzhaogui
     * @date 2020-04-15
     * @return bool
     */
	public function visit()
	{
		$param = $this->request()->getRequestParam();


		/****/
		ServerManager::getInstance()->getProcess('testProcess')->push($param);
        /****/

        if ($param) {
			return $this->writeJson(Status::CODE_OK, '', '登出成功');
		} else {
			return $this->writeJson(Status::CODE_UNAUTHORIZED, '', 'fail');
		}
	}

}