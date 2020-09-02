<?php


namespace app\admin\controller;


use app\BaseController;

class Image extends BaseController
{
    public function upload()
    {
        if (!$this->request->isPost()){
            return show(config('status.error'));
        }
        $file = $this->request->file('file');

        // 上传到本地服务器
        $savename = \think\facade\Filesystem::disk('public')->putFile('image',$file);
        $data = ['image'=>'/upload/'.$savename];
        return show(config('status.success'),'ok',$data);
    }

    public function layUpload()
    {
        if (!$this->request->isPost()){
            return json(['code'=>1,'msg'=>'method error']);
        }
        $file = $this->request->file('file');

        // 上传到本地服务器
        $savename = \think\facade\Filesystem::disk('public')->putFile('image',$file);
        $res = [
            'code' => 0,
            'msg' => 'ok',
            'data' =>[
                'src'=>'/upload/'.$savename
                ]
            ];
        return json($res);

    }

}