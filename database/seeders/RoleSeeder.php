<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Role::create(['name' => 'chief', 'title' => 'Kepala Bagian', 'level' => 1]);
    Role::create(['name' => 'admin', 'title' => 'Administrator', 'level' => 2]);
    Role::create(['name' => 'staff', 'title' => 'Pegawai', 'level' => 3]);
  }
}
