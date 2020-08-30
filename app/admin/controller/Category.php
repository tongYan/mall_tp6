<?php


namespace app\admin\controller;


use app\BaseController;
use think\Exception;
use think\facade\View;
use app\common\business\Category as CategoryBs;

class Category extends BaseController
{
    /**
     * 分类列表
     * @return string
     */
    public function index()
    {
        $pid = $this->request->param('pid',0,'intval');
        $list = (new CategoryBs())->getList($pid);

        return View::fetch('',['categorys'=>$list,'pid'=>$pid]);
    }


    public function add()
    {
        $categorys = (new CategoryBs())->getNormalCategory();
        return View::fetch('',['categorys'=>json_encode($categorys)]);
    }

    /**
     * 添加分类
     * @return \think\response\Json
     * @throws Exception
     */
    public function save()
    {
        if (!$this->request->isPost()){
            return show(config('status.error'),'request error');
        }
        $pid = $this->request->param('pid',0,'intval');
        $name =$this->request->param('name','','trim');
        $validate = new \app\admin\validate\Category();
        $data = ['pid' => $pid,'name' => $name];
        if(!$validate->check($data)){
            throw new Exception($validate->getError());
        }

        try {
            $res = (new CategoryBs())->save($data);
        } catch (Exception $e){
            return show(config('status.error'),$e->getMessage());
        }
        if ($res){
            return show(config('status.success'),'ok');
        }
        return show(config('status.error'),'error');
    }

    public function listOrder()
    {
        $id = input('param.id',0,'intval');
        $listorder = input('param.sort',0,'intval');
        if (empty($id)){
            return show(config('status.error'),'param error');
        }
        try {
            $res = (new CategoryBs())->editListOrder($id,$listorder);
        } catch (Exception $e){
            return show(config('status.error'),$e->getMessage());
        }
        if ($res === false){
            return show(config('status.error'),'edit error');
        }
        return show(config('status.success'),'ok');
    }

    public function status()
    {
        $id = input('param.id',0,'intval');
        $status = input('param.status',0,'intval');
        if (empty($id) || !in_array($status,[0,1,99])){
            return show(config('status.error'),'param error');
        }
        try {
            $res = (new CategoryBs())->editStatus($id,$status);
        } catch (Exception $e){
            return show(config('status.error'),$e->getMessage());
        }
        if ($res === false){
            return show(config('status.error'),'status edit error');
        }
        return show(config('status.success'),'ok');
    }

    public function dialog()
    {
        //获取一级分类
        $categorys = (new CategoryBs())->getNormalCategoryByPid();
        return View::fetch('',['categorys'=>json_encode($categorys)]);
    }

    public function getByPid()
    {
        $pid = $this->request->param('pid',0,'intval');
        $categorys = (new CategoryBs())->getNormalCategoryByPid($pid);
        return show(config('status.success'),'ok',$categorys);
    }

}