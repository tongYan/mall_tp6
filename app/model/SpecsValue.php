<?php


namespace app\model;



class SpecsValue extends BaseModel
{
    public function getBySpecsId($specs_id)
    {
        if (empty($specs_id)){
            return [];
        }
        $res = $this->where(['specs_id'=>$specs_id,'status'=>1])->select();
        return $res->toArray();
    }

    public function updateById($id,$data)
    {
        if (empty($id) || empty($data)){
            return false;
        }
        $data['update_time'] = time();
        return $this->where(['id'=>$id])->update($data);
    }



}