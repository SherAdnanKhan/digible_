<?php

namespace App\Http\Repositories\Users;

use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\Users\SignupActivate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\PersonalAccessTokenResult;

class AuthRepository
{
    /**
     * @param array $userData
     */
    public function register(array $userData): void
    {
        $user = new User($userData);
        $user->notify(new SignupActivate($user));
        Log::info(__METHOD__ . " -- Email verification notification sent to user", ["email" => $user->email]);
        $user->save();
        $user->assignRole('user');

    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function validateUser(string $email, string $password): bool
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);
    }

    /**
     * @param User $user
     * @param $rememberMe
     * @return PersonalAccessTokenResult
     */
    public function createUserToken(User $user, $rememberMe): PersonalAccessTokenResult
    {
        $tokenResult = $user->createToken(env('APP_PERSONAL_TOKEN'));
        $token = $tokenResult->token;
        if ($rememberMe) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        Log::info(__METHOD__ . " -- User login success: ", ["email" => $user->email, "token_expires_at" => $token->expires_at]);

        return $tokenResult;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        return $request->user()->tokens->each(function ($token) {
            $token->delete();
        });
    }

    /**
     * @param $token
     * @return mixed
     */
    public function getUserFromToken($token)
    {
        return User::where('activation_token', $token)->first();
    }

    /**
     * @param User $user
     * @return User
     */
    public function userActivate(User $user): User
    {
        $user->email_verified_at = now();
        $user->status = 'active';
        $user->activation_token = '';
        $user->save();
        return $user;
    }

    public function forget(array $data)
    {
        $data['token'] = str_random(60);
        return PasswordReset::create($data);
    }

    public function confirm(array $data)
    {
        $passwordReset = PasswordReset::where(['token' => $data['token']])->first();

        if (!isset($passwordReset)) {
            return null;
        }
        $passwordReset->where('token', $data['token'])->delete();

        return $passwordReset->user()->update([
            'password' => bcrypt($data['password']),
        ]);
    }

    public function validateTokenAndGetUser(string $token)
    {
        $passwordReset = PasswordReset::with('user')->where(['token' => $token])->first();
        if (!isset($passwordReset) || ($passwordReset->created_at->diffInMinutes(\Carbon\Carbon::now()) > 30)) {
            return null;
        }
        return $passwordReset->user;
    }

    public function resetToken(User $user)
    {
        $user->update(['activation_token' => str_random(5)]);
        $user->notify(new SignupActivate($user));
    }
}
