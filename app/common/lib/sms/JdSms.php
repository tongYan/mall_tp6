<?php


namespace app\common\lib\sms;


use think\facade\Log;

class JdSms implements BaseSms
{
    public static function sendCode(string $phone,int $code ) :bool {
        Log::info("jdsms-sendcode-{$phone}-result ".'ok');
        return true;
    }

}