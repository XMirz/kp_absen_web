<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;

class UserSeeder extends Seeder
{
  use HasFactory;
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $staffs = [
      // [
      //   'name' => 'XMirz',
      //   'email' => 'xmirz@gmail.com',
      //   'password' => Hash::make(1),
      // ],
      [
        'name' => 'Hafez Almirza',
        'email' => 'x@gmail.com',
        'password' => Hash::make(1),
      ],
      [
        'name' => 'Ahmad Paisal',
        'email' => 'paisul@gmail.com',
        'password' => Hash::make(1),
      ], [
        'name' => 'Deny Ardianto',
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
      ],
      [
        'name' => 'Maulana Junihardi',
        'email' => 'maulana@gmail.com',
        'password' => Hash::make(1),
      ],
      [
        'name' => 'Fachrul Rozi',
        'email' => 'rozi@gmail.com',
        'password' => Hash::make(1),
      ],
      [
        'name' => 'Ferdian Arya Dinata',
        'email' => 'ferdian@gmail.com',
        'password' => Hash::make(1),
      ]
    ];

    foreach ($staffs as $s) {
      $s['nip'] = random_int(11111111, 99999999) . '' . random_int(11111111, 99999999);
      $s['gender'] = 'L';
      $s['address'] = 'Pekanbaru';
      $s['birthDate'] = now()->subCenturies(2);
      $staff = User::create($s);
      if ($staff->id == 1) {
        $staff->assignRole('chief');
      } else if (in_array($staff->id, [2])) {
        $staff->assignRole('admin');
      } else {
        $staff->assignRole('staff');
      }
    }
  }
}
