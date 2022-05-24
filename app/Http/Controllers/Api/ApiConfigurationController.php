<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiConfigurationController extends Controller
{
  public function index()
  {
    $today = Carbon::now('+7');
    $config = Configuration::all();
    $response = [
      'latitude' => $config->firstWhere('name', 'latitude')->value,
      'longitude' => $config->firstWhere('name', 'longitude')->value,
      'location' => $config->firstWhere('name', 'location')->value,
      'today' => $today->translatedFormat('l, d M Y'),
    ];
    return response()->json($response, 200);
  }
}
