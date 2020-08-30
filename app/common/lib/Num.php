<?php


namespace app\common\lib;


class Num
{
    public static function getCode($len = 4)
    {
        if ($len == 4){
            return rand(1000,9999);
        }
        return  rand(100000,999999);
    }

}