<?php


namespace app\api\controller;


use app\api\validate\User;
use app\BaseController;
use think\Exception;

class Login extends BaseController
{
    /**
     * 用户 手机验证码方式登录
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function index()
    {
        if (!$this->request->isPost()){
            return show(config('status.error'),'request error');
        }
        $phone_number = $this->request->param('phone_number','','trim');
        $code = $this->request->param('code','','intval');
        $type = $this->request->param('type','','intval');
        $data = [
            'phone_number' => $phone_number,
            'code' => $code,
            'type' => $type,
        ];

        $validet = new User();
        if(!$validet->scene('login')->check($data)){
            return show(config('status.error'),$validet->getError());
        }

        try {
            $result = (new \app\api\business\User())->login($phone_number,$code,$type);
        } catch (Exception $e) {
            return show($e->getCode(),$e->getMessage());
        }
        if ($result == false) {
            return show(config('status.error'),'login error');
        }
        return show(config('status.success'),'login success',$result);
    }

}