<?php


namespace app\admin\business;


use think\Exception;

class AdminUser
{
    public $admin_model;

    public function __construct()
    {
        $this->admin_model = new \app\model\AdminUser();
    }

    /**
     * 用户登录
     * @param $username
     * @param $password
     * @param $captcha
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login($username,$password)
    {
        $user = $this->getUserByUsername($username);
        if (empty($user)) {
            throw new Exception('user not exist',config('status.error'));
        }
        if (!hash_equals($user['password'],md5($password.config('app.md5_suffix')))) {
//            return show(config('status.error'),'password error');
            throw new Exception('password error');
        }

        //更新用户数据
        $data = [
            'last_login_time' => time(),
            'last_login_ip' => request()->ip(),
        ];
        $res = $this->admin_model->updateUserById($user['id'],$data);
        if ($res === false){
            throw new Exception('error');
        }

        session(config('admin.session_admin'),$user);
        return true;
    }

    public function getUserByUsername($username)
    {
        $user = $this->admin_model->getUserByUsername($username);
        if (empty($user) || $user['status'] != config('status.mysql.table_normal')) {
            return [];
        }
        return $user->toArray();
    }

}