<?php


namespace app\common\business;


use app\common\lib\Arr;
use think\Exception;
use think\facade\Log;

class BusBase
{
    public $model;

    public function add($data,$unique='')
    {
        if ($unique){
            $exist = $this->model->where([$unique=>$data[$unique]])->find();
            if ($exist){
                throw new Exception($unique.' exist');
            }
        }
        $data['status'] = config('status.mysql.table_normal');
        try {
            $this->model->save($data);
        } catch (Exception $e) {
            Log::error('busBase_add'.$e->getMessage());
            return false;
        }
        return $this->model->id;

    }

    public function getNormalList($limit=5)
    {
        $order = ['listorder'=>'desc','id'=>'desc'];
        try {
            $res = $this->model->getNormalList($order,$limit);
            $res = $res->toArray();
        } catch (Exception $e) {
            Log::error('getNormalList'.$e->getMessage());
            $res = Arr::getPageDefault($limit);
        }
        return $res;
    }


}