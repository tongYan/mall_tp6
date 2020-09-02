<?php


namespace app\admin\controller;


use app\BaseController;
use think\facade\View;
use  think\facade\Session;

class Goods extends BaseController
{
    public function index()
    {
        $goods = (new \app\common\business\Goods())->getNormalList(5);
//        dump($goods);exit;
        return View::fetch('',['goods'=>$goods]);
    }

    public function add()
    {
        return View::fetch();
    }

    public function sess()
    {
        dump(Session::all());
        dump(Session::get('__token__'));
        dump(Session::has('__token__'));
    }

    public function save()
    {
        if (!$this->request->isPost()){
            return show(config('status.error'),'method error');
        }
        $data = input('param.');
//        dump($data);exit;
        $check = $this->request->checkToken('__token__');
        if (!$check){
//            return show(config('status.error'),'request error');
        }
        $validate = (new \app\admin\validate\Goods());
        if(!$validate->check($data)){
            return show(config('status.error'),$validate->getError());
        }
        $category = $data['category_id'];
        $data['category_path_id'] = $category;
        $category = explode(',',$category);
        $data['category_id'] = end($category);

//        dump($data);die;
        try {
            $res = (new \app\common\business\Goods())->insertData($data);
        }catch (\Exception $e){
            return show(config('status.error'),$e->getMessage());
        }
        if (!$res){
            return show(config('status.error'),'save error');

        }
        return show(config('status.success'),'ok');
    }

}