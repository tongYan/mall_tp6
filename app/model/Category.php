<?php


namespace app\model;


use think\Model;

class Category extends Model
{
    public function getCategoryByName($name)
    {
        if (!$name){
            return [];
        }
        $res = $this->where(['name'=>$name])->find();
        return empty($res) ? [] : $res->toArray();
    }

    public function getCategoryByPid($pid,$limit=5)
    {
        $where[] = ['pid' ,'=',$pid];
        $where[] = ['status','in','0,1'];
        $res = $this->where($where)
            ->order(['listorder'=>'desc','id'=>'desc'])
            ->paginate($limit)->toArray();
        return $res ;
    }

    public function getNormalCategoryByPid($pid)
    {
        $where = ['pid' => $pid,'status' => 1];
        $res = $this->where($where)
            ->order(['listorder'=>'desc','id'=>'desc'])
            ->select();
        return $res ;
    }

    public function updateById($id,$data)
    {
        $data['update_time'] = time();

        return $this->where(['id'=>$id])->update($data);
    }

}