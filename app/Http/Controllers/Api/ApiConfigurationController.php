<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Presence;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiConfigurationController extends Controller
{
  public function index()
  {
    $userId = auth()->user()->id;
    $today = Carbon::now('+7');
    $todayPresence = Presence::where('user_id', $userId)->whereDay('checkInTime', $today)->latest()->first();
    // Check presence eligibility
    if ($todayPresence == null) {
      $eligiblePresence = true;
    } else {
      $eligiblePresence = $todayPresence->checkOutTime != null ? false : true;
    }
    $config = Configuration::all();
    $presencesHistory = Presence::where('user_id', $userId)->latest()->limit(5)->get();
    $response = [
      'latitude' => $config->firstWhere('name', 'latitude')->value,
      'longitude' => $config->firstWhere('name', 'longitude')->value,
      'location' => $config->firstWhere('name', 'location')->value,
      'todayPresence' => $todayPresence ?? null,
      'eligible' => $eligiblePresence,
      'today' => $today->translatedFormat('l, d M Y'),
      'presencesHistory' => $presencesHistory,
    ];
    return response()->json($response, 200);
  }
}
