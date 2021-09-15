<?php
namespace App\Http\Services\Images;

use App\Http\Services\BaseService;
use Illuminate\Support\Facades\File;

class ImageDeleteService extends BaseService
{
    public function removeImage($image_path)
    {
        $path = str_replace(env('APP_URL') . '/', "", $image_path);
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
