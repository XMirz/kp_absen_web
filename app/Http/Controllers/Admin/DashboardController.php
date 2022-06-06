<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
  public function index()
  {
    $staffsCount = User::count();
    $todayPresenceCount = Presence::whereDate('checkInTime', now('+7'))->count();
    return Inertia::render('Dashboard', compact('staffsCount', 'todayPresenceCount'));
  }
}
