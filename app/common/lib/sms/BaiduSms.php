<?php


namespace app\common\lib\sms;


use think\facade\Log;

class BaiduSms implements BaseSms
{
    public static function sendCode(string $phone,int $code ) :bool {
        Log::info("baidusms-sendcode-{$phone}-result $code ".'ok');
        return true;
    }

}