<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PresenceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // TODO csdad
    $today = Carbon::now();
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

    // Monthly
    // Group by month and year
    $groupedAllPresences = Presence::all()->groupBy([
      function ($presence) {
        return $presence->checkInTime->format('Y');
      },
      function ($presence) {
        return $presence->checkInTime->translatedFormat('m');
      },
    ]);

    $yearsMonths = [];
    foreach ($groupedAllPresences as $year => $yearValue) {
      $years = [];
      foreach ($yearValue as $monthNumber => $value) {
        $monthName = Carbon::createFromFormat('Y-m-d', '2022-' . $monthNumber . '-01')->translatedFormat('F');
        $years[$monthNumber] = $monthName;
      }
      $yearsMonths[$year] = $years;
    }

    return Inertia::render('Presence/Index', compact('todayStaffsPresences', 'today', 'yearsMonths'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Presence  $presence
   * @return \Illuminate\Http\Response
   */
  public function show(Presence $presence)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Presence  $presence
   * @return \Illuminate\Http\Response
   */
  public function edit(Presence $presence)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Presence  $presence
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Presence $presence)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Presence  $presence
   * @return \Illuminate\Http\Response
   */
  public function destroy(Presence $presence)
  {
    //
  }
}
