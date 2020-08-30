<?php


namespace app\common\lib;


class Time
{
    public static function getTokenExpire($type = 1)
    {
        return $type==1 ? 7*3600*24 : 30*3600*24;
    }

}