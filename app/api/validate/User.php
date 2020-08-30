<?php


namespace app\api\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username' => ['require'],
        'phone_number' => 'require|mobile',
        'code' => 'require',
        'type' => 'require|in:1,2',
        'sex' => 'require|in:0,1,2'
    ];

    protected $scene = [
        'sendSms' => ['phone_number'],
        'login' => ['phone_number','code','type'],
        'edit' => ['username','sex'],
    ];

}