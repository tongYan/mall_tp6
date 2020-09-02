<?php
/**
 * Created by singwa
 * User: singwa
 * motto: 现在的努力是为了小时候吹过的牛逼！
 * Time: 23:42
 */
namespace app\api\controller\mall;
use app\api\controller\ApiBase;
use app\common\lib\Show;
use app\common\business\Goods as GoodsBis;

class Detail extends ApiBase {

    public function index()
    {
        $id = input("param.id", 0, "intval");
        if(!$id) {
            return Show::error();
        }

        $result = (new GoodsBis())->getGoodsDetailBySkuId($id);
        if(!$result) {
            return Show::error();
        }
        return Show::success($result);
    }
}