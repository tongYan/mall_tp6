<?php


namespace app\model;


use think\Model;

class User extends Model
{
    protected $autoWriteTimestamp = true;

    /**
     * 根据手机号获取用户信息
     * @param $phone
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserByPhone($phone)
    {
        if (!$phone){
            return [];
        }
        $res = $this->where(['phone_number'=>$phone])->find();
        return empty($res) ? [] : $res->toArray();
    }

    public function getUserById($id,$field='*')
    {
        if (!$id){
            return [];
        }
        return $this->where(['id'=>intval($id)])->field($field)->find();
    }

    public function getUserByUsername($username)
    {
        if (!$username){
            return [];
        }
        return $this->where(['username'=>$username])->find();
    }
}