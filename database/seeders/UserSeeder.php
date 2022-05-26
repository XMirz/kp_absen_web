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
    $staffs = [
      [
        'name' => 'Hafez Almirza',
        'email' => 'a@gmail.com',
        'password' => Hash::make(1),
      ],
      [
        'name' => 'XMirz',
        'email' => 'x@gmail.com',
        'password' => Hash::make(1),
      ],
      [
        'name' => 'Ahmad Paisal',
        'email' => 'paisul@gmail.com',
        'password' => Hash::make(1),
      ], [
        'name' => 'Deny Ardianto',
        'address' => 'Pekanbaru',
        'email' => 'deny@gmail.com',
        'password' => Hash::make(1),
      ], [
        'name' => 'Isnan Melian Ramadhan',
        'email' => 'isnan@gmail.com',
        'password' => Hash::make(1),
      ], [
        'name' => 'M. Ilham Habibie',
        'email' => 'habibi@gmail.com',
        'password' => Hash::make(1),
      ]
    ];

    foreach ($staffs as $s) {
      $s['nip'] = $this->faker->randomNumber(8) . $this->faker->randomNumber(8);
      $s['gender'] = $this->faker->randomElement(['L', 'P']);
      $s['address'] = $this->faker->address();
      $s['birthDate'] = $this->faker->date();
      $staff = User::create($s);
      if (in_array($staff->id, [1, 2])) {
        $staff->assignRole('chief');
      } else {
        $staff->assignRole('staff');
      }
    }
  }
}
