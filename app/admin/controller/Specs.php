<?php


namespace app\admin\controller;


use app\BaseController;
use think\facade\View;

class Specs extends BaseController
{
    public function dialog()
    {
        $specs = config('specs');
//        dump($specs);die;
        return View::fetch('',['specs'=>json_encode($specs)]);
    }


}