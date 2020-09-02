<?php


namespace app\api\controller;

use app\common\business\Category as CategoryBs;
use app\common\lib\Show;
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

    /**
     * api/category/search/51  预留给大家的作业记得完成
     * 商品列表页面中 按栏目检索的内容
     * @return \think\response\Json
     */
    public function search() {
        $id = input('param.id','','intval');
        if (!$id){
            return Show::success();
        }
        $result = (new CategoryBs())->getIndexCategoryById($id);
        return Show::success($result);

    }

    /**
     * 获取子分类  category/sub/2   预留给大家的作业记得完成
     * @return \think\response\Json
     */
    public function sub() {
        $id = input('param.id','','intval');
        if (!$id){
            return Show::success();
        }
        $result = (new CategoryBs())->getNormalCategoryByPid($id);
        return Show::success($result);

    }

}