<?php


namespace app\model;


use think\Model;

class AdminUser extends Model
{
    protected $autoWriteTimestamp = true;
    /**
     * 根据用户名获取用户信息
     * @param $username
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserByUsername($username)
    {
        if (!$username){
            return [];
        }
        $res = $this->where(['username'=>$username])->find();
        return $res;
    }
    public function updateUserById($id,$data) {
        $id = intval($id);
        if (empty($id) || empty($data) || !is_array($data)){
            return false;
        }

        return $this->where(['id'=>$id])->save($data);
    }

}