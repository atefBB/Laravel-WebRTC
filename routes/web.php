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
  return json_encode($d->now());                    
  /*dd(file_put_contents(
        $img_save_path,
        base64_decode($captured_image)));*/

      /*if (
          preg_match(
              '/data:image\/(gif|jpeg|png);base64,(.*)/i',
              $captured_image,
              $matches))
              {
          $imageType = $matches[1];
          $imageData = base64_decode($matches[2]);
          $image = imagecreatefromstring($imageData);
          $filename = 'img_'.$d->toDateString().'.png';

          if (
                imagepng(
                  $image,
                  storage_path().'/app/imgs/'. $filename))
          {
              echo json_encode(
                      array('filename' => '/app/imgs/' . $filename));
          } else {
              throw new Exceptionecho ('Could not save the file.');
          }
      } else {
          throw new Exceptionecho ('Invalid data URL.');
      }*/
});
