<?php
// 应用公共文件

/**
 * 通用化API数据格式输出
 * @param $status
 * @param string $message
 * @param array $data
 * @param int $httpStatus
 * @return \think\response\Json
 */
function show($status,$message='error',$data=[],$httpStatus=200){
    $res = [
        'status' => $status,
        'message' => $message,
        'result' => $data
    ];
    return json($res,$httpStatus);
}
