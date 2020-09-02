<?php


namespace app\common\business;


use app\common\business\GoodsSku as GoodsSkuBis;
use app\common\business\SpecsValue as SpecsValueBis;
use think\Exception;
use think\facade\Cache;
use think\facade\Log;

class Goods extends BusBase
{
    public function __construct()
    {
        $this->model = new \app\model\Goods();
    }
    public function insertData($data)
    {

        $this->model->startTrans();
        try {
            $goods_id = $this->add($data);
            if (!$goods_id){
                return false;
            }
            if ($data['goods_specs_type']==1){
                $goods_sku_data = ['goods_id'=>$goods_id];
                //todo
                return true;
            }

            //多规格  启动事务
            if (!isset($data['skus']) || empty($data['skus'])){
                throw new Exception(' skus no data');
                return  false;
            }
            //批量添加sku信息
            $data['goods_id']=$goods_id;
            $skus = (new GoodsSku())->mutiAdd($data);

            if (!$skus){
                throw new Exception('sku add error');
            }
            $stock = array_sum(array_column($skus,'stock'));

            $update = [
                'stock' =>$stock,
                'sku_id' => $skus[0]['id'],
                'price' => $skus[0]['price'],
                'cost_price' => $skus[0]['cost_price']
            ];
            //sku信息回写到goods
            $res = $this->model->updateById($goods_id,$update);
            if (!$res){
                throw new Exception('goods update error');
            }
            // 提交事务
            $this->model->commit();
        } catch (\Exception $e) {
            Log::error('goods_insertData'.$e->getMessage());
            // 回滚事务
            $this->model->rollback();
            return false;
        }
        return true;

    }

    public function getRotationChart() {
        $data = [
            "is_index_recommend" => 1,
        ];
        $field = "sku_id as id, title, big_image as image";

        try {
            $result = $this->model->getNormalGoodsByCondition($data, $field, 5);
        }catch (\Exception $e) {
            return [];
        }
        return $result->toArray();
    }

    public function cagegoryGoodsRecommend($categoryIds) {
        if(!$categoryIds) {
            return [];
        }
        // 栏目
        foreach ($categoryIds as $k => $categoryId) {
            $result[$k]["categorys"] = (new Category())->getChildByPids([$categoryId]);
        }
//        $result["categorys"] = (new Category())->getChildByPids($categoryIds);

        foreach($categoryIds as $key => $categoryId) {
            $result[$key]["goods"] = $this->getNormalGoodsFindInSetCategoryId($categoryId);
        }
        return $result;
    }



    public function getNormalGoodsFindInSetCategoryId($categoryId) {
        $field = "sku_id as id, title, price , recommend_image as image";
        try {
            $result = $this->model->getNormalGoodsFindInSetCategoryId($categoryId, $field);
        }catch (\Exception $e) {
            return [];
        }
        return $result->toArray();
    }

    public function getNormalLists($data, $num = 5, $order) {
        try {
            $field = "sku_id as id, title, recommend_image as image,price";
            $list = $this->model->getNormalLists($data, $num, $field, $order);
            $res = $list->toArray();
            $result = [
                "total_page_num" => isset($res['last_page']) ? $res['last_page'] : 0,
                "count" => isset($res['total']) ? $res['total'] : 0,
                "page" => isset($res['current_page']) ? $res['current_page'] : 0,
                "page_size" => $num,
                "list" => isset($res['data']) ? $res['data'] : []
            ];
        }catch (\Exception $e) {
            ///echo $e->getMessage();exit;
            // 演示之前的地方
            $result = [];
        }
        return $result;
    }

    public function getGoodsDetailBySkuId($skuId) {
        // sku_id sku表 => goods_id goods表 => tilte image description
        // sku  => sku数据
        // join
        $skuBisObj = new GoodsSkuBis();
        $goodsSku = $skuBisObj->getNormalSkuAndGoods($skuId);

        if(!$goodsSku) {
            return [];
        }
        if(empty($goodsSku['goods'])) {
            return [];
        }
        $goods = $goodsSku['goods'];
        $skus = $skuBisObj->getSkusByGoodsId($goods['id']);

        if(!$skus) {
            return [];
        }
        $flagValue = "";
        foreach($skus as $sv) {
            if($sv['id'] == $skuId) {
                $flagValue = $sv["specs_value_ids"];
            }
        }
        $gids = array_column($skus, "id", "specs_value_ids");

        //统一规格
        if($goods['goods_specs_type'] == 1) {
            $sku = [];
        } else {
            $sku = (new SpecsValueBis())->dealGoodsSkus($gids, $flagValue);
        }
        $result = [
            "title" => $goods['title'],
            "price" => $goodsSku['price'],
            "cost_price" => $goodsSku['cost_price'],
            "sales_count" => 0,
            "stock" => $goodsSku['stock'],
            "gids" => $gids,
            "image" => $goods['carousel_image'],
            "sku" => $sku,
            "detail" => [
                "d1" => [
                    "商品编码" => $goodsSku['id'],
                    "上架时间" => $goods['create_time'],
                ],
                "d2" => preg_replace('/(<img.+?src=")(.*?)/', '$1'.config('app.app_host').'$2',$goods['description']),
            ],

        ];

        // 记录数据到redis 作为商品PV统计
        Cache::inc("mall_pv_".$goods['id']);
        return $result;

    }

}