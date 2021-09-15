<?php
namespace App\Http\Services\Images;

use App\Http\Services\BaseService;
use Illuminate\Support\Facades\Storage;

class ImageUploadService extends BaseService
{
    protected $path = "public/images/";
    public function uploadImage($image, $uploadFolder)
    {
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $uploadedImageResponse = array("image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $image->getClientMimeType(),
        );
        return $uploadedImageResponse;
    }
}
