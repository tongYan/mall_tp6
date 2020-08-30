<?php


namespace app\api\controller;

use app\common\business\Category as CategoryBs;
use think\Exception;

class Category extends ApiBase
{
    public function index()
    {
        try {
            $categorys =(new CategoryBs())->getSliceTree();
        } catch (Exception $e){
            return show(config('status.success'),$e->getMessage());

        }
        return show(config('status.success'),'ok',$categorys);
    }

}