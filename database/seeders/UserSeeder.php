<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Container\Container;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  protected $faker;
  public function __construct()
  {
    $this->faker = Factory::create('id_ID');
  }
  public function run()
  {
    User::create([
      'name' => 'Hafez Almirza',
      'profile' => 'anu',
      'address' => 'anu',
      'email' => 'a@gmail.com',
      'password' => Hash::make(1),
    ])->assignRole('chief');

    $staffs = [
      [
        'name' => 'XMirz',
        'profile' => 'belum Bang',
        'address' => 'Belum',
        'role' => 'staff',
        'email' => 'x@gmail.com',
        'password' => Hash::make(1),
      ],
      [
        'name' => 'Ahmad Paisal',
        'address' => 'Pekanbaru',
        'profile' => 'anu',
        'email' => 'paisul@gmail.com',
        'password' => Hash::make(1),
      ], [
        'name' => 'Deny Ardianto',
        'address' => 'Pekanbaru',
        'profile' => 'anu',
        'email' => 'deny@gmail.com',
        'password' => Hash::make(1),
      ], [
        'name' => 'Isnan Melian Ramadhan',
        'address' => 'Pekanbaru',
        'profile' => 'anu',
        'email' => 'isnan@gmail.com',
        'password' => Hash::make(1),
      ], [
        'name' => 'M. Ilham Habibie',
        'address' => 'Pekanbaru',
        'profile' => 'anu',
        'email' => 'habibi@gmail.com',
        'password' => Hash::make(1),
      ]
    ];

    foreach ($staffs as $s) {
      $s['nip'] = $this->faker->randomNumber(8) + $this->faker->randomNumber(8);
      $staff = User::create($s);
      $staff->assignRole('staff');
    }
  }
}
