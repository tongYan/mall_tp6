<?php
// admin中间件定义文件
return [
    // Session初始化
    \think\middleware\SessionInit::class,
    \app\admin\middleware\Auth::class,
];
