<?php

/**
 * aliyun 发送短信
 */

declare(strict_types=1);


namespace app\common\lib\sms;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use think\facade\Log;


class AliSms implements BaseSms
{
    public static function sendCode(string $phone,int $code ) :bool
    {
        if (empty($phone) || empty($code)) {
            return false;
        }

        AlibabaCloud::accessKeyClient(config('aliyun.access_key_id'), config('aliyun.access_secret'))
            ->regionId(config('aliyun.region_id'))
            ->asDefaultClient();

        $param = json_encode(['code'=>$code]);
        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host(config('aliyun.host'))
                ->options([
                    'query' => [
                        'RegionId' => config('aliyun.region_id'),
                        'PhoneNumbers' => $phone,
                        'SignName' => config('aliyun.sign_name'),
                        'TemplateCode' => config('aliyun.template_code'),
                        'TemplateParam' => $param,
                    ],
                ])
                ->request();
            Log::info("alisms-sendcode-{$phone}-result ".json_encode($result->toArray()));
        } catch (ClientException $e) {
            Log::error("alisms-sendcode-{$phone}-ClientException ".$e->getErrorMessage());
            return false;
//            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            Log::error("alisms-sendcode-{$phone}-ServerException .".$e->getErrorMessage());

            return false;
//            echo $e->getErrorMessage() . PHP_EOL;
        }

        if (isset($result['Code']) && $result['Code'] === 'OK')
        return true;
    }

}