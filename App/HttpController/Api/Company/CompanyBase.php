<?php
/**
 * User: Andy
 * Date: 2020/4/8
 * Time: 22:04
 */

namespace App\HttpController\Api\Company;

use App\HttpController\Api\ApiBase;
use EasySwoole\EasySwoole\Config;
use EasySwoole\Http\Message\Status;
use EasySwoole\Jwt\Jwt;

class CompanyBase extends ApiBase
{

	/**
	 * 公司主键
	 *
	 * @var $companyId int
	 */
	protected $companyId;
	protected $jwtData;

	// 白名单
	protected $whiteList = [];

	public function onRequest(?string $action): ?bool
	{
		if (parent::onRequest($action)) {
			// 白名单判断
			if (in_array($action, $this->whiteList)) {
				return true;
			}

			// 获取登录信息
			$params = $this->request()->getRequestParam();

			try {
				$token = $params['sign_id'];
				$config = Config::getInstance()->getConf('JWT');
				$jwtObject = Jwt::getInstance()
					->setSecretKey($config['secret'])
					->decode($token);

				$this->jwtData = $jwtObject->getData();

				$jwtObject->getAlg();
				$jwtObject->getAud();
				$jwtObject->getExp();
				$jwtObject->getIat();
				$jwtObject->getIss();
				$jwtObject->getNbf();
				$jwtObject->getJti();
				$jwtObject->getSub();
				$jwtObject->getSignature();
				$jwtObject->getProperty('alg');

				$this->companyId = $this->jwtData['uid'];

			} catch (\EasySwoole\Jwt\Exception $e) {
				return false;
			}
			return true;
		}

		return false;
	}

}