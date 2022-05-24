<?php

namespace Database\Seeders;

use App\Models\Staff;
use Hash;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Staff::create([
      'name' => 'Hafez Almirza',
      'profile' => 'anu',
      'address' => 'anu',
      'role' => 'admin',
      'email' => 'a@gmail.com',
      'password' => Hash::make(1),
    ]);
    Staff::create([
      'name' => 'XMirz',
      'profile' => 'belum Bang',
      'address' => 'Belum',
      'role' => 'staff',
      'email' => 'x@gmail.com',
      'password' => Hash::make(1),
    ]);
    Staff::create([
      'name' => 'Ahmad Paisal',
      'address' => 'Pekanbaru',
      'profile' => 'anu',
      'role' => 'staff',
      'email' => 'paisul@gmail.com',
      'password' => Hash::make(1),
    ]);
    Staff::create([
      'name' => 'Deny Ardianto',
      'address' => 'Pekanbaru',
      'profile' => 'anu',
      'role' => 'staff',
      'email' => 'deny@gmail.com',
      'password' => Hash::make(1),
    ]);
    Staff::create([
      'name' => 'Isnan Melian Ramadhan',
      'address' => 'Pekanbaru',
      'profile' => 'anu',
      'role' => 'staff',
      'email' => 'isnan@gmail.com',
      'password' => Hash::make(1),
    ]);
    Staff::create([
      'name' => 'M. Ilham Habibie',
      'address' => 'Pekanbaru',
      'profile' => 'anu',
      'role' => 'staff',
      'email' => 'habibi@gmail.com',
      'password' => Hash::make(1),
    ]);
  }
}
