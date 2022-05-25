<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use Illuminate\Http\Request;

class ApiPresenceController extends Controller
{



  public function store(Request $request)
  {
    $presenceData['checkInTime'] = now('+7');
    $presenceData['user_id'] = auth()->user()->id;
    $presenceData['inArea'] = $request->inArea;
    $presenceData['checkInDistance'] = $request->distance;
    $presenceData['checkInLocation'] = json_encode($request->location);
    $todayPresence = Presence::create($presenceData);
    return response()->json([
      'todayPresence' => $todayPresence,
    ], 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  public function update(Request $request, Presence $presence)
  {
    $presence->checkOutTime = now('+7');
    $presence->checkOutDistance = $request->distance;
    $presence->checkOutLocation = json_encode($request->location);
    $presence->update();
    return response()->json([
      'todayPresence' => $presence,
    ], 200);
  }
  public function destroy($id)
  {
    //
  }
}
