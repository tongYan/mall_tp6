<?php


namespace app\common\business;


use think\Exception;

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

        $this->model->save($data);
        return $this->model->id;

    }

}