<?php
namespace App\Http\Services\Admins;

use App\Http\Repositories\Admins\AdminRepository;
use App\Http\Services\BaseService;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminService extends BaseService
{

    /**
     * @var AdminRepository
     */
    protected $repository;
    protected $service;

    public function __construct(
        AdminRepository $repository,
        BaseService $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @param array $data
     */
    public function register(array $data): void
    {
        Log::info(__METHOD__ . " -- New user request info: ", array_except($data, ["password"]));

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $data['name'] = Str::lower($data['name']);
        $data['email'] = Str::lower($data['email']);
        $data['timezone'] = $data['timezone'];
        $data['status'] = 'active';
        $data['email_verified_at'] = now();
        $this->repository->register($data);
    }

    public function getAll()
    {
        $result = $this->repository->getAll();
        return $this->service->paginate($result);
    }

    public function update(array $data, User $user)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);

    }
}
