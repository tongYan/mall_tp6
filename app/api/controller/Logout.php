<?php


namespace app\api\controller;

class Logout extends AuthBase
{
    public function index()
    {
        $res = cache(config('redis.token_pre').$this->access_token,null);
        if ($res) {
            return show(config('status.success'),'logout ok');
        }
        return show(config('status.error'),'logout error');
    }

}