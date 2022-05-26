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
    // Presence::create([
    //   'inArea' => false,
    //   'checkInDistance' => 122,
    //   'checkInLocation' => 'asdsad',
    //   'checkInTime' => now(),
    //   'user_id' => 1,
    // ]);
    Presence::create([
      'inArea' => false,
      'checkInDistance' => 122,
      'checkInLocation' => json_encode([
        'longitude' => 0.5003650855,
        'latitude' =>  101.38777053,
      ]),
      'checkOutLocation' => json_encode([
        'longitude' => 0.5003650855,
        'latitude' =>  101.38777053,
      ]),
      'checkInTime' => now('+7')->subDays(5),
      'checkOutTime' => now('+7')->subDays()->addHours(4),
      'user_id' => 4,
    ]);
    Presence::create([
      'inArea' => false,
      'checkInDistance' => 122,
      'checkInLocation' => json_encode([
        'longitude' => 0.5003650855,
        'latitude' =>  101.38777053,
      ]),
      'checkOutLocation' => json_encode([
        'longitude' => 0.5003650855,
        'latitude' =>  101.38777053,
      ]),
      'checkInTime' => now('+7')->subDays(4),
      'checkOutTime' => now('+7')->subDays(4)->addHours(4),
      'user_id' => 4,
    ]);
    Presence::create([
      'inArea' => false,
      'checkInDistance' => 122,
      'checkInLocation' => json_encode([
        'longitude' => 0.5003650855,
        'latitude' =>  101.38777053,
      ]),
      'checkOutLocation' => json_encode([
        'longitude' => 0.5003650855,
        'latitude' =>  101.38777053,
      ]),
      'checkInTime' => now('+7')->subDays(3),
      'checkOutTime' => now('+7')->subDays(3)->addHours(4),
      'user_id' => 4,
    ]);
    Presence::create([
      'inArea' => false,
      'checkInDistance' => 122,
      'checkInLocation' => json_encode([
        'longitude' => 0.5003650855,
        'latitude' =>  101.38777053,
      ]),
      'checkOutLocation' => json_encode([
        'longitude' => 0.5003650855,
        'latitude' =>  101.38777053,
      ]),
      'checkInTime' => now('+7')->subDays(2),
      'checkOutTime' => now('+7')->subDays(2)->addHours(4),
      'user_id' => 4,
    ]);
    Presence::create([
      'inArea' => false,
      'checkInDistance' => 122,
      'checkInLocation' => json_encode([
        'longitude' => 0.5003650855,
        'latitude' =>  101.38777053,
      ]),
      'checkOutLocation' => json_encode([
        'longitude' => 0.5003650855,
        'latitude' =>  101.38777053,
      ]),
      'checkInTime' => now('+7')->subDays(1),
      'checkOutTime' => now('+7')->subDays(1)->addHours(4),
      'user_id' => 4,
    ]);
  }
}
