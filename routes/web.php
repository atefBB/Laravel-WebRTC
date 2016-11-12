<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    // default => return view('welcome');
    return view('index');
});

Route::post('save_img', function() {
  $captured_image = Request::get('data');
  $d = new Carbon\Carbon();
  $img_save_path = storage_path().'/app/imgs/img_'.$d->toDateString().'.png';
  dd(file_put_contents($img_save_path, $captured_image));
});
