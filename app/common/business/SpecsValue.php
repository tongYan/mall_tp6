<?php


namespace app\common\business;


class SpecsValue extends BusBase
{
    public function __construct()
    {
        $this->model = new \app\model\SpecsValue();
    }

    public function getBySpecsId($specs_id)
    {
        return $this->model->getBySpecsId($specs_id);
    }

    public function updateById($id,$data)
    {
        return $this->model->updateById($id,$data);
    }

}