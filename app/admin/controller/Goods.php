<?php


namespace app\admin\controller;


use app\BaseController;
use think\facade\View;

class Goods extends BaseController
{
    public function index()
    {
        return View::fetch();
    }

    public function add()
    {
        return View::fetch();
    }

}