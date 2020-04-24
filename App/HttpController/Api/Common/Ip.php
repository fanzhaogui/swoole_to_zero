<?php
/**
 * Created by PhpStorm.
 * User: fanzhaogui
 * Date: 2020/4/24
 * Time: 10:38
 */

namespace App\HttpController\Api\Common;


class Ip extends CommonBase
{
    /**
     * 获取IP地址
     *
     * @author: fanzhaogui
     * @param string $headerName
     *
     * @api ssc.3qma.com:9501/Api/Common/Ip/client
     */
    public function client($headerName = 'x-real-ip')
    {
        $address =  parent::clientRealIP($headerName);

        return $this->writeJson(200, ['ip' => $address]);
    }
}