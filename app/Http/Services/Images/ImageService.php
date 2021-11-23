<?php
namespace App\Http\Services\Images;

use Image;
use App\Http\Services\BaseService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageService extends BaseService
{
    public function uploadImage($base64, $folderName, $width = 400, $height = 400)
    {
    $image = str_replace(['data:image/png;base64,','data:image/gif;base64,', 'data:image/jpeg;base64,', 'data:image/jpg;base64,'], '', $base64);
    $imageName = md5(rand(11111, 99999)) . '_' . time() . '.png';
    $path =  $imageName;
    $input = File::put($path, base64_decode($image));
    $image = Image::make($path)->resize($width, $height);
    $result = $image->save($path);
    return $imageName;
    }

    public function removeImage($image_path)
    {
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
    }

}
