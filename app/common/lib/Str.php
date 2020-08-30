<?php


namespace app\common\lib;


class Str
{
    /**
     * 生成不重复的token
     * @param $string
     * @return string
     */
    public static function getLoginToken($string)
    {
        $str = md5(uniqid(md5(microtime(true)),true));
        return sha1($str.$string);

    }


}