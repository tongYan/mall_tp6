<?php


namespace app\admin\controller;


class Logout
{
    /**
     * 退出登录
     * @return \think\response\Redirect
     */
    public function index()
    {
        session(config('admin.session_admin'),null);
        return redirect(url('login/index'));
    }

}