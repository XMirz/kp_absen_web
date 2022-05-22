<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    User::create([
      'name' => 'Hafez Almirza',
      'profile' => 'anu',
      'address' => 'anu',
      'role' => 'admin',
      'email' => 'a@gmail.com',
      'password' => Hash::make(1),
    ]);
    User::create([
      'name' => 'XMirz',
      'profile' => 'belum Bang',
      'address' => 'Belum',
      'role' => 'staff',
      'email' => 'x@gmail.com',
      'password' => Hash::make(1),
    ]);

    $this->call([
      ConfigurationSeeder::class,
    ]);
  }
}
