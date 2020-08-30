<?php

use think\facade\Route;

Route::post('smscode','sms/sendcode');
Route::resource('user','user');
