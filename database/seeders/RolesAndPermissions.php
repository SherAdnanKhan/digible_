<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissions extends Seeder {
 /**
  * Run the database seeds.
  *
  * @return void
  */
 public function run() {
  $role = Role::findOrCreate('admin');
  $role = Role::findOrCreate('user');
  $role = Role::findOrCreate('seller');
 }
}
