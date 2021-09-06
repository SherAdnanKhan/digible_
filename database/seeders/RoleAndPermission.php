<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndPermission extends Seeder {
 /**
  * Run the database seeds.
  *
  * @return void
  */
 public function run() {
  DB::table('roles')->delete();
  $role = Role::create(['name' => 'admin']);
  $user = User::where('name', 'admin')->first();
  if (!$user) {
   $user = User::create(['name' => 'admin', 'email' => 'admin@admin.com', 'password' => Hash::make('12345678')]);
  }
  $user->assignRole('admin');
  $role = Role::create(['name' => 'user']);
  $role = Role::create(['name' => 'seller']);
 }
}
