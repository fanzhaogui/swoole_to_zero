<?php
/**
 * Created by PhpStorm.
 * User: fanzhaogui
 * Date: 2020/4/10
 * Time: 17:51
 */

namespace App\Utility\Pool;


use EasySwoole\Pool\ObjectInterface;

class RedisObject extends \Redis implements ObjectInterface
{
    public function gc()
    {
        $this->close();
    }


    public function objectRestore()
    {

    }

    /**
     * 使用前判断是否可用
     *
     * @author: fanzhaogui
     * @return bool|null
     */
    public function beforeUse():?bool
    {
        return true;
    }
}