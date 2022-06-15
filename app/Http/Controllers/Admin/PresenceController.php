<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
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

    $presence->isVerified = true;
    $presence->save();
    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Presence  $presence
   * @return \Illuminate\Http\Response
   */
  public function destroy(Presence $presence)
  {
    $presence->delete();
    return redirect()->back();
  }
}
