<?php
namespace App\Http\Services\Users;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use App\Http\Repositories\Users\AuthRepository;
use Laravel\Passport\PersonalAccessTokenResult;
use App\Http\Transformers\Users\UserTransformer;

class AuthService extends BaseService
{
    /**
     * @var UserTransformer
     */

    /**
     * @var AuthRepository
     */

    public function __construct(
        AuthRepository $repository,
        UserTransformer $transformer
    ) {
        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param array $data
     */
    public function register(array $data): void
    {
        Log::info(__METHOD__ . " -- New user request info: ", array_except($data, ["password"]));

        $userData = array_except($data, ['avatar']);

        if (isset($userData['password'])) {
            $userData['password'] = bcrypt($userData['password']);
        }
        $userData['activation_token'] = str_random(5);
        $userData['name'] = Str::lower($data['name']);
        $userData['email'] = Str::lower($data['email']);
        $userData['timezone'] = $data['timezone'];
        $userData['status'] = 'new';
        $this->repository->register($userData);
    }

    /**
     * @param array $data
     * @return PersonalAccessTokenResult|null
     * @throws ErrorException
     */
    public function login(array $data): ?PersonalAccessTokenResult
    {
        Log::info(__METHOD__ . " -- User login attempt: ", ["email" => $data["email"]]);

        if (!$this->repository->validateUser($data['email'], $data['password'])) {
            Log::error(__METHOD__ . " -- User entered wrong email or password. ", ["email" => $data["email"]]);
            return null;
        }

        $user = User::where('email', $data['email'])->first();

        return $this->repository->createUserToken($user, $data['remember_me'] ?? null);
    }

    /**
     * @param Request $request
     */
    public function logout(Request $request): void
    {
        $this->repository->logout($request);
        Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- User logout success");
    }

    /**
     * @param $token
     * @return User|null
     */
    public function userActivate($token)
    {
        $user = $this->repository->getUserFromToken($token);
        if (!$user) {
            return null;
        }

        $user = $this->repository->userActivate($user);


        Log::info(__METHOD__ . " -- user: " . $user->email . " -- User email verification success");

        Event::dispatch('email.verified', [$user]);

        Log::info(__METHOD__ . " -- Email verification success notification sent to user", ["email" => $user->email]);

        return $this->repository->createUserToken($user, null);
    }

    public function forget(array $data)
    {
        $result = $this->repository->forget($data);
        $user = User::where('email', $data['email'])->first();
        $data = [
            'user' => $user,
            'token' => $result['token'],
        ];

        Log::info(__METHOD__ . " -- user: " . $user->email . " -- User forget password request");

        Event::dispatch('password.reset', $data);
    }

    public function confirm(array $data)
    {
        return $this->repository->confirm($data);
    }

    public function validateTokenAndGetUser(string $token)
    {
        return $this->repository->validateTokenAndGetUser($token);
    }

    public function resetToken(User $user)
    {
        return $this->repository->resetToken($user);
    }
}
