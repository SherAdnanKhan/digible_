<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('name', 'seller')->first();
        if (!$user) {
            $user = User::create(['name' => 'seller', 'email' => 'seller@gmail.com',
                'password' => Hash::make('12345678'), 'timezone' => config('app.timezone'),
                'email_verified_at' => now()]);
        }
        $user->assignRole('seller');

    }
}
