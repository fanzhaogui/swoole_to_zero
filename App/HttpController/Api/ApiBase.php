<?php
/**
 * Created by PhpStorm.
 * User: Tioncico
 * Date: 2019/3/29 0029
 * Time: 10:45
 */

namespace App\HttpController\Api;

use App\HttpController\BaseController;
use EasySwoole\EasySwoole\Core;
use EasySwoole\EasySwoole\Trigger;
use EasySwoole\Http\Exception\ParamAnnotationValidateError;
use EasySwoole\Http\Message\Status;

abstract class ApiBase extends BaseController
{
    public function index()
    {
		// return $this->writeJson(200, 'OK');
    	$this->actionNotFound('index');
    }

    protected function actionNotFound(?string $action): void
    {
        $this->writeJson(Status::CODE_NOT_FOUND);
    }

    public function onRequest(?string $action): ?bool
    {
        if (!parent::onRequest($action)) {
            return false;
        }
        return true;
    }

	/**
	 * 系统异常时，触发的事件
	 * @param \Throwable $throwable
	 */
    protected function onException(\Throwable $throwable): void
    {
        if ($throwable instanceof ParamAnnotationValidateError) {
            $msg = $throwable->getValidate()->getError()->getErrorRuleMsg();
            $this->writeJson(400, null, "{$msg}");
        } else {
            if (Core::getInstance()->isDev()) {
                $this->writeJson(500, null, $throwable->getMessage());
            } else {
                Trigger::getInstance()->throwable($throwable);
                $this->writeJson(500, null, '系统内部错误，请稍后重试');
            }
        }
    }
}