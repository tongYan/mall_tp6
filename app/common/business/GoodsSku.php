<?php


namespace app\common\business;


use think\Exception;
use think\facade\Log;

class GoodsSku extends BusBase
{
    public function __construct()
    {
        $this->model = new \app\model\GoodsSku();
    }

    public function mutiAdd($data)
    {
        if (!isset($data['skus'])){
            return false;
        }
        $skus = $data['skus'];
        foreach ($skus as $v){
            $v = $v['propvalnames'];
            $add[] = [
                'goods_id' => $data['goods_id'],
                'specs_value_ids' => $v['propvalids'],
                'price' => $v['skuSellPrice'],
                'cost_price' => $v['skuMarketPrice'],
                'stock' => $v['skuStock'],
                'status' => 1
                ];
        }
        try {
            $res = $this->model->saveAll($add);
            return $res->toArray();
        } catch (Exception $e){
            //todo  log
            Log::error("goods_sku_mutiadd".$e->getMessage());
            return false;
        }

    }

    public function getNormalSkuAndGoods($id) {
        try {
            $result = $this->model->with("goods")->find($id);
        }catch(\Exception $e) {
            return [];
        }
        if(!$result) {
            return [];
        }
        $result = $result->toArray();
        if($result['status'] != config("status.mysql.table_normal")) {
            return [];
        }
        return $result;

    }

    public function getSkusByGoodsId($goodsId = 0) {
        if(!$goodsId) {
            return [];
        }
        try {
            $skus = $this->model->getNormalByGoodsId($goodsId);
        }catch (\Exception $e) {
            return [];
        }
        return $skus->toArray();
    }
    public function getNormalInIds($ids) {
        try {
            $result = $this->model->getNormalInIds($ids);
        }catch (\Exception $e) {
            return [];
        }
        return $result->toArray();
    }

}