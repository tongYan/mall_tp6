<?php

/**
 * 工厂模式类库
 */

namespace app\common\lib;



class ClassArr
{
    public static function smsClassArr()
    {
        return [
            'ali' => 'app\common\lib\sms\AliSms',
            'baidu' => 'app\common\lib\sms\BaiduSms',
            'jd' => 'app\common\lib\sms\JdSms',
        ];
    }

    public static function initClass($type,$class,$param=[],$need_instance=false)
    {
        if(!isset($class[$type])) {
            return false;
        }

         return $need_instance ? (new \ReflectionClass($class))->newInstanceArgs($param) : $class[$type];

    }

}