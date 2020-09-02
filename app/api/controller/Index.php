<?php

namespace app\api\controller;
use app\common\business\Goods as GoodsBis;
use app\common\lib\Show;

class Index extends ApiBase {

    /**
     * 首页轮播图商品
     * @return \think\response\Json
     */
    public function getRotationChart() {
        $result = (new GoodsBis())->getRotationChart();
        return Show::success($result);
    }

    public function cagegoryGoodsRecommend() {
        //推荐的分类
        $categoryIds = [
            //71,51
            17,16
        ];
        $result = (new GoodsBis())->cagegoryGoodsRecommend($categoryIds);
        return Show::success($result);
    }
}