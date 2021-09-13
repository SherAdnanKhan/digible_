<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('name', 'admin')->first();
        if (!$user) {
            $user = User::create(['name' => 'admin', 'email' => 'admin@admin.com', 'password' => Hash::make('12345678')]);
        }
        $user->assignRole('admin');
    }
}
