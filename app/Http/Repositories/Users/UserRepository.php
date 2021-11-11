<?php

namespace App\Http\Repositories\Users;

use App\Models\User;

class UserRepository
{
    /**
     * @param array $userData
     */
    public function getUsers()
    {
        $user = User::with('roles')->whereHas('roles', function ($query) {
            return $query->where('name', '!=', 'admin');})->get();
        return $user;
    }
}
