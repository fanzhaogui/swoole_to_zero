<?php
/**
 * Created by PhpStorm.
 * User: fanzhaogui
 * Date: 2020/4/15
 * Time: 15:00
 */


namespace App\Utility;


/**
 * 头像
 *
 * @package App\Utility
 */
class Gravatar
{
    /**
     * 生成一个Gavatar头像
     *
     * @see https://en.gravatar.com/site/implement/images/php/
     *
     * @author: fanzhaogui
     * @date 2020-04-15
     * @param string $email
     * @param int $size
     * @return string
     */
    public static function makeGravatar(string $email, int $size = 120)
    {
        $hash =  md5( strtolower( trim( $email ) ) );

        return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d=identicon";
    }
}