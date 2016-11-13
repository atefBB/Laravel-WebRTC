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
  Carbon\Carbon::setToStringFormat('j_F_Y_g-i-s-a');
  $img_save_path = storage_path()
                    .'/app/imgs/img_'
                    .$d->now()
                    .'.png';
  //dd($img_save_path);
  /*$decoded_img = base64_decode(
                  preg_replace(
                      '#^data:image/\w+;base64,#i',
                      '',
                      $captured_image));*/
  $captured_image = str_replace(
                      'data:image/png;base64,',
                      '',
                      $captured_image);
  $captured_image = str_replace(
                      ' ',
                      '+',
                      $captured_image);
  if(is_bool(file_put_contents(
              $img_save_path,
              base64_decode($captured_image))))
  {
    return json_encode([
      'status'  => false,
      'message' => "Prob while saving image"
    ]);
  }
  return json_encode([
    'status'  => true,
    'message' => 'Image saved at: '.$d->toDateTimeString()
  ]);
});
