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
       $user = User::all();
       return $user;
    }
}
