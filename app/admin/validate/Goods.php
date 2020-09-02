<?php


namespace app\admin\validate;


use think\Validate;

class Goods extends Validate
{
    public $rule = [
        'title' => 'require',
        'sub_title' => 'require',
        'category_id' =>'require',
        'promotion_title' => 'require',
        'goods_unit' => 'require',
        'keywords' => 'require',
        'stock' => 'require|integer',
//        'price' =>'checkPrice',
//        'cost_price' =>'checkPrice',
        'is_show_stock' => 'require|in:0,1',
        'production_time' =>'require',
        'goods_specs_type' => 'require|in:1,2',
        'big_image' => 'require',
        'recommend_image' => 'require',
        'carousel_image' => 'require',
        'description' => 'require',
//        'is_index_recommend' => 'require|in:0,1',
    ];

    protected function checkPrice($value, $rule, $data=[])
    {
        if ($value['goods_specs_type']==1 && empty($value['price'])){
            return 'price can not empty';
        }
        return true;
    }

}