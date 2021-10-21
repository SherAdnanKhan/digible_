<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\ItemTypeSeeder;
use Database\Seeders\RolesAndPermissions;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([RolesAndPermissions::class]);
        $this->call([AdminSeeder::class]);
        $this->call([UserSeeder::class]);
        $this->call([SellerSeeder::class]);
        $this->call([ItemTypeSeeder::class]);
    }
}
