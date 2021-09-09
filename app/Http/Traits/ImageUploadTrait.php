<?php

namespace App\Traits;

use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImageUploadTrait {
 protected $path = "public/images/";
 public function uploadImage($image, $uploadFolder) {
  $image_uploaded_path = $image->store($uploadFolder, 'public');
  $uploadedImageResponse = array("image_name" => basename($image_uploaded_path),
   "image_url" => Storage::disk('public')->url($image_uploaded_path),
   "mime" => $image->getClientMimeType(),
  );
  return $uploadedImageResponse;
 }

 public function uploadImages($name, $img, $i, $folderName, $image_width = NULL, $image_height = NULL): string {
  $image_name = $this->randomImageName($name, $img, $i);

  Image::make($img->getRealPath())
   ->resize($image_width, $image_height, function ($constraint) {
    $constraint->aspectRatio();
   })->save(storage_path($this->path . $folderName . '/' . $image_name), 100);

  return $image_name;
 }
}