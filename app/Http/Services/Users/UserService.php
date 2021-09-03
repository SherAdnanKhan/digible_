<?php
namespace App\Http\Services\Users;

use App\Http\Services\BaseService;
use App\Http\Services\Uploads\FileUploadService;
use App\Models\User;
use App\Repositories\Compressions\Images\ImageRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserService extends BaseService
{
    /**
     * @var FileUploadService/
     */
    private FileUploadService $service;

    /**
     * @var ImageRepositoryInterface
     */
    private ImageRepositoryInterface $imageRepository;

    public function __construct(FileUploadService $service, ImageRepositoryInterface $imageRepository)
    {
        $this->service = $service;
        $this->imageRepository = $imageRepository;
    }

    /**
     * @return Authenticatable|null
     */
    public function getAll(): ?Authenticatable
    {
        return Auth()->user();
    }

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function updatePassword(User $user, array $data) : bool
    {
        $userPassword = false ;
        if (Hash::check($data['password'], $user->password))
        {
            Log::info(__METHOD__ . " -- user: " . $user->email . " -- User updated the password:", $data);
            return $user->update([
                'password' => bcrypt($data['new_password']),
            ]);
        }

        return $userPassword ;
    }

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function updateUser(User $user , array $data) : bool
    {
        if (isset($data['username'])) {
            $data['username'] = Str::lower($data['username']);
        }

        if (isset($data['profile_image'])) {
            if ( !is_null($user->profile_image) )
                $this->service->deleteFile(storage_path('app/public/').$user->profile_image);

            $data['profile_image'] = $this->service->uploadFile($data['profile_image'], [
                'width' => 300,
                'height' => 300,
                'quality' => 90
            ], 'users/profile/' . hash('sha256', $user->id) . '/');
        }

        Log::info(__METHOD__ . " -- user: " . $user->email . " -- User update his account information:", $data);

        return $user->update($data);
    }
}
