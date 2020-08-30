<?php


namespace app\api\controller;


use app\api\validate\User;
use app\BaseController;
use think\exception\ValidateException;

class Sms extends BaseController
{
    public function  cache()
    {
        cache('name','指针');
        dump(cache('name'));

    }

    public function sendCode()
    {
        $phone_number = $this->request->param('phone_number');
        try {
            validate(User::class)->scene('sendSms')->check(['phone_number' => $phone_number]);
        } catch (ValidateException $e) {
            return show(config('status.error'),$e->getError());
        }

        //流控
        if (rand(0,99) <80){

        }else{

        }
        if (!\app\api\business\Sms::sendCode($phone_number,4,'baidu')) {
            return show(config('status.error'),'send failed');
        }

        return show(config('status.success'),'send code success');
    }

}