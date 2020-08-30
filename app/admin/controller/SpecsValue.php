<?php


namespace app\admin\controller;


use app\BaseController;
use think\Exception;
use think\facade\View;
use app\common\business\SpecsValue as SpecsValueBs;

class SpecsValue extends BaseController
{
    public function save()
    {
        $specs_id = $this->request->param('specs_id',0,'intval');
        $name = $this->request->param('name',0,'trim');
        if (empty($specs_id) || empty($name)){
            return show(config('status.error'),'param error');
        }

        $data = ['specs_id'=>$specs_id,'name'=>$name,'status'=>1];
        try {
            $res = (new SpecsValueBs())->add($data,'name');
        } catch (Exception $e){
            return show(config('status.error'),$e->getMessage());
        }
        if ($res){
            return show(config('status.success'),'ok');
        }
        return show(config('status.error'),'error');



    }

    public function getBySpecsId()
    {
        $specs_id = $this->request->param('specs_id',0,'intval');
        if (empty($specs_id)){
            return show(config('status.error'),'param error');
        }
        $res = (new SpecsValueBs())->getBySpecsId($specs_id);
        return show(config('status.success'),'ok',$res);
    }

    public function status()
    {
        $id = $this->request->param('id',0,'intval');
        $status = $this->request->param('status',0,'intval');
        if (empty($id) || empty($status)){
            return show(config('status.error'),'param error');
        }
        $res = (new SpecsValueBs())->updateById($id,['status'=>$status]);
        if ($res){
            return show(config('status.success'),'ok');
        }
        return show(config('status.error'),'error');
    }

}