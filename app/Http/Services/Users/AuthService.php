<?php
namespace App\Http\Services\Users;

use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use App\Models\User;
use App\Http\Repositories\Users\AuthRepository;
use App\Http\Transformers\Users\UserTransformer;
use App\Http\Services\Uploads\FileUploadService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Passport\PersonalAccessTokenResult;

class AuthService extends BaseService
{
    /**
     * @var UserTransformer
     */
    private UserTransformer $transformer;

    /**
     * @var AuthRepository
     */
    private AuthRepository $repository;

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
    public function register(array $data) : void
    {
        Log::info(__METHOD__ . " -- New user request info: ", array_except($data, ["password"]));
        $filePath = null;
        if (isset($data['avatar'])) {
            $filePath = (new FileUploadService())->uploadFile($data['avatar'], 'users/');
        }

        $userData = array_except($data, ['avatar']);

        if (isset($userData['password'])) {
            $userData['password'] = bcrypt($userData['password']);
        }

        if (isset($filePath)) {
            $userData['avatar'] = $filePath;
        }

        $userData['username'] = Str::lower($data['username']);
        $userData['invitation_code'] = $userData['ic'] ?? null;
        $userData['activation_token'] = str_random(60);
        $userData['status'] = User::USER_STATUS_NEW;
        $this->repository->register($userData);
    }

    /**
     * @param array $data
     * @return PersonalAccessTokenResult|null
     * @throws ErrorException
     */
    public function login(array $data) : ?PersonalAccessTokenResult
    {
        Log::info(__METHOD__ . " -- User login attempt: ", ["email" => $data["email"]]);

        if (!$this->repository->validateUser($data['email'], $data['password'])) {
            Log::error(__METHOD__ . " -- User entered wrong email or password. ", ["email" => $data["email"]]);
            return null;
        }

        $user = User::where('email', $data['email'])->first();

        switch ($user->status) {
            case User::USER_STATUS_NEW:
                Log::error(__METHOD__ . " -- Email not verified ", ["email" => $data["email"]]);
                throw new ErrorException('exception.user_email_not_verified', [], Response::HTTP_UNPROCESSABLE_ENTITY);
            case User::USER_STATUS_DISABLED:
                Log::error(__METHOD__ . " -- User account disabled ", ["email" => $data["email"]]);
                throw new ErrorException('exception.account_disabled', [], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->repository->createUserToken($user, $data['remember_me'] ?? null);
    }

    /**
     * @param Request $request
     */
    public function logout(Request $request) : void
    {
        $this->repository->logout($request);
        Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- User logout success");
    }

    /**
     * @param $token
     * @return User|null
     */
    public function userActivate($token) : ?User
    {
        $user = $this->repository->getUserFromToken($token);
        if (!$user) {
            return null;
        }

        $user = $this->repository->userActivate($user);

        Log::info(__METHOD__ . " -- user: " . $user->email . " -- User email verification success");

        Event::dispatch('email.verified', [$user]);

        Log::info(__METHOD__ . " -- Email verification success notification sent to user", ["email" => $user->email]);

        return $user;
    }

    public function forget(array $data)
    {
        $result = $this->repository->forget($data);
        $user = User::where('email', $data['email'])->first();
        $data = [
            'user' => $user,
            'token' => $result['token']
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
}
