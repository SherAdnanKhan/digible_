<?php
namespace App\Http\Services\Images;

use App\Http\Services\BaseService;
use Illuminate\Support\Facades\File;
use Image;

class ImageService extends BaseService
{
    public function uploadImage($base64, $folderName, $width = 400, $height = 400)
    {
        $image = preg_replace('/^data:image\/[A-z]+;base64,/', "", $base64);
        $imageName = md5(rand(11111, 99999)) . '_' . time() . '.png';
        $path = $imageName;
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
