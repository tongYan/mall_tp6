<?php


namespace app\controller;


use app\BaseController;

class Error extends BaseController
{
    public function __call($name, $arguments)
    {
//        return parent::__call($name,$arguments);
//        dump($name,$arguments);
//        die;
        return show(config('status.controller_not_found'),"controller not found");

    }

}