<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $config = [
      [
        'name' => 'location',
        'value' => 'Jl. Abdul Rahman Hamid ,Kelurahan Tuah Negeri, Kec. Tenayan Raya, Kota Pekanbaru, Riau 28285',
        'description' => ''
      ],
      [
        'name' => 'postalcode',
        'value' => '28285',
        'description' => ''
      ],
      [
        'name' => 'latitude',
        'value' => '0.5172036',
        'description' => ''
      ],
      [
        'name' => 'longitude',
        'value' => '101.5407860',
        'description' => ''
      ],
    ];
    foreach ($config as $c) {
      Configuration::create($c);
    }
  }
}
