<?php

use think\facade\Route;

Route::post('smscode','sms/sendcode');
Route::resource('user','user');
Route::rule('category/search/:id','category/search');
Route::rule('subcategory/:id','category/sub');
Route::rule('detail/:id','mall.detail/index');
Route::rule('lists','mall.lists/index');
