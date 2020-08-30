<?php


namespace app\api\business;


use app\common\lib\Str;
use app\common\lib\Time;
use think\Exception;

class User
{
    public $user_model;

    public function __construct()
    {
        $this->user_model = new \app\model\User();
    }
    public function login($phone,$code,$type)
    {
        if (empty($phone) || empty($code) || empty($type) || !in_array($type,[1,2])) {
            return false;
        }
        //判断code
        $redis_code = cache(config('redis.code_pre').$phone);
        if (empty($redis_code) || $redis_code != $code) {
            throw new Exception('code error',config('status.error'));
        }
        $user = $this->user_model->getUserByPhone($phone);
//        $user_id = 0;
//        $username = '';
        if (empty($user)){
            //添加用户
            $username = 'mall_user_'.$phone;
            $data = [
                'username' => $username,
                'phone_number' => $phone,
                'type' => $type,
                'status' => config('status.mysql.table_normal')

            ];
            try {
                $this->user_model->save($data);
                $user_id = $this->user_model->id;
            } catch (Exception $e) {
                throw new Exception('mysql inner error');
            }

        } else{
            //更新表数据 update_time last_login_ip last_login_time

            $user_id = $user['id'];
            $username = $user['username'];
        }

        //生成token
        $token = Str::getLoginToken($phone);

        $data = [
            'token' => $token,
            'username' => $username,
            'user_id' => $user_id
        ];
        $res = cache(config('redis.token_pre').$token,$data,Time::getTokenExpire($type));

        return $res ? $data : false;

    }

    public function getNormalUserById($id)
    {
        $user = $this->user_model->getUserById($id,'id,username,sex,status,type');
        if (empty($user) || $user->status != config('status.mysql.table_normal')) {
            return [];
        }
        return $user->toArray();

    }

    public function updateUserById($id,$data,$token)
    {
        //判断用户是否存在
        $user = $this->getNormalUserById($id);
        if (empty($user)) {
            throw new Exception('user not exist');
        }
        //判断用户名是否存在
        $username = $this->user_model->getUserByUsername($data['username']);
        if (!empty($username) && $username->id != $id){
            throw new Exception('username exist');
        }

        $data['update_time'] = time();
        $res = $this->user_model->where(['id'=>$id])->update($data);
        if (false === $res){
            return false;
        }

        $user_info = cache(config('redis.token_pre').$token);
        $user_info['username'] = $data['username'];
        $cache_res = cache(config('redis.token_pre').$token,$user_info,Time::getTokenExpire($user['type']));

        return true;



    }

}