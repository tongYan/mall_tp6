<?php


namespace app\model;


use think\Model;

class BaseModel extends Model
{
    public $autoWriteTimestamp= true;

    public function updateById($id,$data)
    {
        if (empty($id) || empty($data)){
            return false;
        }
        $data['update_time'] = time();
        return $this->where(['id'=>$id])->update($data);
    }

    public function getNormalList($order=[],$limit=5)
    {
        if (empty($order)){
            $order = ['listorder'=>'desc','id'=>'desc'];
        }
        return $this->whereIn('status',[0,1])
            ->order($order)
            ->paginate($limit);
    }

    public function getNormalInIds($ids) {
        return $this->whereIn("id", $ids)
            ->where("status", "=", config("status.mysql.table_normal"))
            ->select();
    }

    /**
     * 根据条件查询
     * @param array $condition
     * @param array $order
     * @return bool|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getByCondition($condition = [], $order = ["id" => "desc"]) {
        if(!$condition || !is_array($condition)) {
            return false;
        }
        $result = $this->where($condition)
            ->order($order)
            ->select();

        ///echo $this->getLastSql();exit;
        return $result;
    }


}