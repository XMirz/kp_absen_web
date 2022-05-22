<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ApiConfigurationController extends Controller
{
  public function index()
  {
    $config = Configuration::all();
    $response = [
      'latitude' => $config->firstWhere('name', 'latitude')->value,
      'longitude' => $config->firstWhere('name', 'longitude')->value,
      'location' => $config->firstWhere('name', 'location')->value,
    ];
    return response()->json($response, 200);
  }
}
