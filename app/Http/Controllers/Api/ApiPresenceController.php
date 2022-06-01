<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\User;
use Arr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Nette\Utils\Arrays;
use Nette\Utils\Json;

class ApiPresenceController extends Controller
{

  public function index(Request $request)
  {
    $rawStaffs = User::with('roles')->get();
    $staffs = $rawStaffs->filter(function (User $staff) {
      if ($staff->roles()->first()->level != 0) {
        return $staff;
      }
    })->values();

    $today = now(+7);
    $day = Carbon::createFromDate($request->year ?? $today->format('Y'), $request->month ?? $today->format('m'), '01');
    $month = $request->month ?? $today->format('m');
    $year = $request->year ?? $today->format('Y');
    foreach ($staffs as $staff) {
      $staff->presences = Presence::where('user_id', $staff->id)->whereYear('checkInTime', '=', $year)->whereMonth('checkInTime', '=', $month)->get();
      // unset($staff->roles);
    }


    // Fetch holiday Api
    $holidayJson = file_get_contents('https://api-harilibur.vercel.app/api?year=' . $year . '&month=' . $month);
    $holiday = Json::decode($holidayJson);
    // dd($holiday);
    // Get all day from the request month
    $daysInMonth = [];
    for ($i = 1; $i < $day->daysInMonth + 1; $i++) {
      $newDay = [];
      $newDay['date'] =  Carbon::createFromFormat('Y-m-d', $year . '-' . $month . '-' . $i);
      $newDay['isWeekend'] = in_array($newDay['date']->translatedFormat('l'), ['Sabtu', 'Minggu']);

      $newDay['holidayName'] = '';
      // Check if current looping day is matched for  a day in Holiday APi;
      $isHoliday = Arrays::some($holiday, function ($day, $index) use (&$newDay) {
        // @var $day is an object ,not an array
        $holidayDate =  Carbon::createFromFormat('Y-m-d', $day->holiday_date);
        $isSameDay = $holidayDate->isSameDay($newDay['date']);
        if ($isSameDay) {
          $newDay['holidayName'] = $day->holiday_name;
        }
        return $isSameDay;
      });
      $newDay['isHoliday'] =  $isHoliday;
      $daysInMonth[] = $newDay;
    }
    $response = [];
    $response["day"] = $day;
    $response["month"] = $month;
    $response["year"] = $year;
    $response["totalDaysInMonth"] = $day->daysInMonth;
    $response["daysInMonth"] = $daysInMonth;
    $response["staffsMonthlyPresences"] = $staffs;
    return response()->json($response);
  }

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
