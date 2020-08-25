<?php


namespace app\controller;


use app\BaseController;

class Demo extends BaseController
{
    public function show()
    {
        $data = [
            "msg" => 0,
            'ret' => [
                'id' =>1
            ]
        ];

        return json($data);
    }

}