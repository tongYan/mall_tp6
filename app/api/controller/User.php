<?php


namespace app\api\controller;

use \app\api\business\User as Userbs;

class User extends AuthBase
{
    /**
     * 获取用户信息
     * @return \think\response\Json
     */
    public function index()
    {
        $userinfo = (new Userbs())->getNormalUserById($this->user_id);
        return show(config('status.success'),'ok',$userinfo);
    }

    public function update()
    {
        $username = $this->request->param('username','','trim');
        $sex = $this->request->param('sex',0,'intval');
        $validate = new \app\api\validate\User();
        $data = ['username' => $username,'sex' => $sex];
        if (!$validate->scene('edit')->check($data)){
            return show(config('status.error'),$validate->getError());
        }
        $res = (new Userbs())->updateUserById($this->user_id,$data,$this->access_token);
        if (!$res) {
            return show(config('status.error'),'edit error');
        }
        return show(config('status.success'),'ok');
    }

}