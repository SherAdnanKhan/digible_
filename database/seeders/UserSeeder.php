<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('name', 'user')->first();
        if (!$user) {
            $user = User::create(['name' => 'user', 'email' => 'user@gmail.com',
                'password' => Hash::make('12345678'), 'timezone' => config('app.timezone'),
                'email_verified_at' => now()]);
        }
        $user->assignRole('user');

    }
}
