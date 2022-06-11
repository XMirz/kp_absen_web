<?php

namespace Database\Seeders;

use App\Models\Presence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresenceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // today
    for ($user = 1; $user < 9; $user++) {
      Presence::create([
        'inArea' => false,
        'checkInDistance' => 20230,
        'checkInLocation' => json_encode([
          'longitude' => 0.5003650855,
          'latitude' =>  101.38777053,
        ]),
        'checkOutLocation' => json_encode([
          'longitude' => 0.5003650855,
          'latitude' =>  101.38777053,
        ]),
        'checkInTime' => now('+7'),
        'checkOutTime' => now('+7')->addHours(4),
        'user_id' => $user,
      ]);
    }

    for ($i = 1; $i < 4; $i++) {
      for ($j = 6; $j > 0; $j--) {
        Presence::create([
          'inArea' => false,
          'checkInDistance' => 20230,
          'checkInLocation' => json_encode([
            'longitude' => 0.5003650855,
            'latitude' =>  101.38777053,
          ]),
          'checkOutLocation' => json_encode([
            'longitude' => 0.5003650855,
            'latitude' =>  101.38777053,
          ]),
          'checkInTime' => now('+7')->subDays($j),
          'checkOutTime' => now('+7')->subDays($j)->addHours(4),
          'user_id' => $i,
        ]);
      }
    }
    for ($i = 1; $i < 4; $i++) {
      for ($j = 6; $j > -1; $j--) {
        Presence::create([
          'inArea' => false,
          'checkInDistance' => 20230,
          'checkInLocation' => json_encode([
            'longitude' => 0.5003650855,
            'latitude' =>  101.38777053,
          ]),
          'checkOutLocation' => json_encode([
            'longitude' => 0.5003650855,
            'latitude' =>  101.38777053,
          ]),
          'checkInTime' => now('+7')->subDays($j * 3)->subMonth(),
          'checkOutTime' => now('+7')->subDays($j * 3)->subMonth()->addHours(4),
          'user_id' => $i,
        ]);
      }
    }
    for ($i = 8; $i > 0; $i--) {
      for ($j = 6; $j > -1; $j--) {
        Presence::create([
          'inArea' => false,
          'checkInDistance' => 20230,
          'checkInLocation' => json_encode([
            'longitude' => 0.5003650855,
            'latitude' =>  101.38777053,
          ]),
          'checkOutLocation' => json_encode([
            'longitude' => 0.5003650855,
            'latitude' =>  101.38777053,
          ]),
          'checkInTime' => now('+7')->subDays($j * 2)->subMonth()->subYear(),
          'checkOutTime' => now('+7')->subDays($j * 2)->subMonth()->subYear()->addHours(4),
          'user_id' => $i,
        ]);
      }
    }
  }
}
