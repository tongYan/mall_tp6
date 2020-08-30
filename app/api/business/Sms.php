<?php

declare(strict_types=1);


namespace app\api\business;


use app\common\lib\ClassArr;
use app\common\lib\Num;

class Sms
{
    public static function sendCode(string $phone,int $len,string $type='ali'): bool
    {
        if (empty($phone)) {
            return false;
        }

        //生成验证码
        $code = Num::getCode($len);

        //发送验证码
        $class = ClassArr::smsClassArr();
        $class_obj = ClassArr::initClass($type,$class);
        if ($class_obj == false) {
            return false;
        }
        $res = $class_obj::sendCode($phone,$code);
        if (!$res) {
            return false;
        }

        //todo 记录code到Redis
        cache(config('redis.code_pre').$phone,$code,config('redis.expire'));
        return true;
    }

}