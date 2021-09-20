<?php
namespace App\Http\Services\Users;

use App\Http\Repositories\Users\UserRepository;
use App\Http\Services\BaseService;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserService extends BaseService
{
    protected $repository;
    protected $service;

    public function __construct(UserRepository $repository, BaseService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getAll(): ?Authenticatable
    {
        return Auth()->user();
    }

    public function getUsers()
    {
        $result = $this->repository->getUsers();
        return $this->service->paginate($result);
    }

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function updatePassword(User $user, array $data): bool
    {
        $userPassword = false;
        if (Hash::check($data['password'], $user->password)) {
            Log::info(__METHOD__ . " -- user: " . $user->email . " -- User updated the password:", $data);
            return $user->update([
                'password' => bcrypt($data['new_password']),
            ]);
        }

        return $userPassword;
    }

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function updateUser(User $user, array $data): bool
    {
        if (isset($data['username'])) {
            $data['username'] = Str::lower($data['username']);
        }

        Log::info(__METHOD__ . " -- user: " . $user->email . " -- User update his account information:", $data);

        return $user->update($data);
    }
}
