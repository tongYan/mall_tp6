<?php


namespace app\admin\validate;


use think\Validate;

class Category extends Validate
{
    public $rule = [
        'pid' => 'require',
        'name' => 'require'
    ];


}