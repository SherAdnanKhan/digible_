<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait RemoveImageTrait {

 public function removeImage($image_path) {
    $path =  str_replace(env('APP_URL').'/', "", $image_path);
  if (File::exists($path)) {
    File::delete($path);
  }
 }}
