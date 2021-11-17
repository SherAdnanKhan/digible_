<?php

namespace App\Http\Repositories\Admins;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class AdminRepository
{
    /**
     * @param array $userData
     */
    public function register(array $userData): void
    {
        $user = new User($userData);

        Log::info(__METHOD__ . " -- Email verification notification sent to user", ["email" => $user->email]);
        $user->save();
        $user->assignRole('admin');
    }

    public function getAll()
    {
        $user = User::with('roles')->whereHas('roles', function ($query) {
            return $query->where('name', '=', 'admin');})->where('id', '!=', auth()->user()->id)->get();
        return $user;
    }

}
