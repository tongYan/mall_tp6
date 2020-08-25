<?php


namespace app\admin\controller;


use app\admin\business\AdminUser;
use app\BaseController;
use think\Exception;
use think\facade\View;

class Login extends BaseController
{
    public function index()
    {
        return View::fetch();
    }


    public function check()
    {
        $username = $this->request->param('username','','trim');
        $password = $this->request->param('password','','trim');
        $captcha = $this->request->param('captcha','','trim');
        $data = [
            'username' => $username,
            'password' => $password,
            'captcha'  => $captcha
        ];
        $validate = new \app\admin\validate\AdminUser();
        if (!$validate->check($data)){
            return show(config('status.error'),$validate->getError());
        }

        try {
            (new AdminUser())->login($username,$password);
        } catch (Exception $e) {
            //todo log $e->getMessage()
            return show(config('status.error'),$e->getMessage());
        }

        return show(config('status.success'),"login success");
    }

}