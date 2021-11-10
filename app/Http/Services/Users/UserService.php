<?php
namespace App\Http\Services\Users;

use App\Http\Repositories\Users\UserRepository;
use App\Http\Services\BaseService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService extends BaseService
{
    protected $repository;
    protected $service;

    public function __construct(UserRepository $repository, BaseService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getAll()
    {
        return User::with('collections')->find(Auth()->id());
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
        Log::info(__METHOD__ . " -- user: " . $user->email . " -- User update his account information:", $data);
        if (isset($data['addresses'])) {
            $addresses = $data['addresses'];
            foreach ($addresses as $address) {
                $id = isset($address['id']) ? $address['id'] : null;
                $user->walletAddresses()->UpdateOrCreate(
                    ['id' => $id],
                    ['address' => $address['address']]);
            }
        }
        return $user->update($data);

    }
}
