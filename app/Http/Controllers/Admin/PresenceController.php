<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Response;

class PresenceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $today = Carbon::now('+7');
    // Verify all presence berfore today, if exist
    $allPresences = Presence::whereDate('checkInTime', '<', $today)->where('isVerified', false)->get();
    foreach ($allPresences as $presence) {
      $presence->isVerified = true;
      $presence->save();
    }

    // TODO csdad
    $rawStaffs = User::with('roles')->get();
    $presences = [];
    // Filter staff
    $staffs = $rawStaffs->filter(function (User $staff) {
      if ($staff->roles()->first()->level != 0) {
        return $staff;
      }
    })->values();
    foreach ($staffs as $staff) {
      $staff->todayPresence = Presence::where('user_id', $staff->id)->whereDate('checkInTime', '=', now('+7')->format('Y-m-d'))->first();
    }
    $todayStaffsPresences = $staffs;
    return Inertia::render('Presence/Index', compact('todayStaffsPresences', 'today'));
  }


  public function store(Request $request)
  {
    //
  }

  public function show(User $user)
  {
    $staff = $user;
    $groupedAllPresences = Presence::where('user_id', $staff->id)->get()->groupBy([
      function ($presence) {
        return $presence->checkInTime->format('Y');
      },
      function ($presence) {
        return $presence->checkInTime->translatedFormat('m');
      },
    ]);
    $reportYearsMonths = [];
    foreach ($groupedAllPresences as $year => $yearValue) {
      $years = [];
      foreach ($yearValue as $monthNumber => $value) {
        $monthName = Carbon::createFromFormat('Y-m-d', '2022-' . $monthNumber . '-01')->translatedFormat('F');
        $years[$monthNumber] = $monthName;
      }
      $reportYearsMonths[$year] = $years;
    }
    return Inertia::render('Presence/Show', compact('staff', 'reportYearsMonths'));
  }

  public function update(Request $request, Presence $presence)
  {

    $presence->isVerified = true;
    $presence->save();
    return redirect()->back();
  }


  public function destroy(Presence $presence)
  {
    $presence->delete();
    return redirect()->back();
  }
}
