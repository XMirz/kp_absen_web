<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Presence;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Type\Integer;

class ApiConfigurationController extends Controller
{
  public function index()
  {
    $userId = auth()->user()->id;
    $today = Carbon::now('+7');
    $todayPresence = Presence::where('user_id', $userId)->whereDate('checkInTime', $today)->latest()->first();
    // Check presence eligibility
    // Check if current time beetween 8 and lessthan 16
    $eligibleHours =  intval($today->translatedFormat('H')) > 6 && intval($today->translatedFormat('H')) < 23;

    // Check if the day is holiday 
    $eligibleDay = !$this->isHoliday($today) && !in_array($today->translatedFormat('l'), ['Sabtu', 'Minggu']);
    if ($todayPresence == null) {
      $eligiblePresence = true;
    } else {
      $eligiblePresence = $todayPresence->checkOutTime != null ? false : true;
    }
    $eligible = $eligibleDay && $eligiblePresence && $eligibleHours;
    $config = Configuration::all();
    // Fetch latest presence except today
    $presencesHistory = Presence::where('user_id', $userId)->latest()->whereDate('checkInTime', '!=', now('+7'))->limit(4)->get();
    $response = [
      'latitude' => $config->firstWhere('name', 'latitude')->value,
      'longitude' => $config->firstWhere('name', 'longitude')->value,
      'location' => $config->firstWhere('name', 'location')->value,
      'todayPresence' => $todayPresence ?? null,
      'eligible' => $eligible,
      'today' => $today->translatedFormat('l, d M Y'),
      'presencesHistory' => $presencesHistory,
    ];
    return response()->json($response, 200);
  }
}
