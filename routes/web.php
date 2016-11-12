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
  //$img_save_path = storage_path().'/app/imgs/img_'.$d->toDateString().'.png';
  //dd(file_put_contents($img_save_path, $captured_image));

      if (
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
              /*throw new Exception*/echo ('Could not save the file.');
          }
      } else {
          /*throw new Exception*/echo ('Invalid data URL.');
      }
});
