<?php


namespace app\admin\validate;


use think\Validate;

class AdminUser extends Validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'captcha'  => 'require|checkCaptcha',
    ];

    protected $message = [
        'username.require' => "用户名没填呀"
    ];

    public function checkCaptcha($value, $rule, $data=[])
    {
        if (!captcha_check($value)) {
            return 'captcha errorr';
        }
        return true;
    }

}