<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\Staff;
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
    $staffsPresence = Staff::all();
    $presences = [];
    foreach ($staffsPresence as $staff) {
      $staff->todayPresence = Presence::where('user_id', $staff->id)->whereDate('checkInTime', '=', now('+7')->format('Y-m-d'))->first();
    }
    return Inertia::render('Presence/Index', compact('staffsPresence', 'presences'));
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
