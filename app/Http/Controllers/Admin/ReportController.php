<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\User;
use Arr;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str as SupportStr;
use Inertia\Inertia;
use Nette\Utils\Arrays;
use Nette\Utils\Json;
use Response;
use Spatie\Browsershot\Browsershot;
use Storage;
use Str;
use View;

class ReportController extends Controller
{
  public function index()
  {
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
    $reportYearsMonths = [];
    foreach ($groupedAllPresences as $year => $yearValue) {
      $years = [];
      foreach ($yearValue as $monthNumber => $value) {
        $monthName = Carbon::createFromFormat('Y-m-d', '2022-' . $monthNumber . '-01')->translatedFormat('F');
        $years[$monthNumber] = $monthName;
      }
      $reportYearsMonths[$year] = $years;
    }
    return Inertia::render('Report/Index', compact('reportYearsMonths'));
  }

  // Printing
  public function show(Request $request)
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
      $staff->presences = Presence::where('user_id', $staff->id)->whereYear('checkInTime', '=', $year)->whereMonth('checkInTime', '=', $month)->get()->groupBy(function ($item) {
        return (int)$item->checkInTime->format('d');
      });
      // unset($staff->roles);
    }


    // Fetch holiday Api
    $holidayJson = file_get_contents(public_path() . '/data/holiday/' . $year . '.json');
    $yearHoliday = Json::decode($holidayJson);
    // Month Holiday
    $holiday = Arr::where($yearHoliday, function ($day, $index) use ($year, $month) {
      return Str::contains($day->holiday_date, "$year-$month");
    });
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
        return $isSameDay && $day->is_national_holiday;
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
    $response["monthlyStaffsPresences"] = $staffs;
    $response["chief"] = User::role('chief')->first();

    $fileName = 'Rekap_Absensi_' . now('+7')->translatedFormat('F-Y');
    $filePath = public_path() . "/generated/pdf/$fileName";

    $response['pageTitle'] = 'Rekapitulasi Absensi ' . now('+7')->translatedFormat('F Y');
    $html = view('pdf.monthly-report', $response)->render();
    // $domPdf = Pdf::loadView('pdf.monthly-report', compact('response', 'pageTitle'))->setPaper('a4', 'landscape');

    $pdf = Browsershot::html($html)
      ->setNodeBinary('/usr/bin/node')
      ->setNpmBinary('/usr/bin/npm')
      ->waitUntilNetworkIdle()
      ->noSandbox()
      ->format('A4')
      ->setOption('addStyleTag', json_encode(['path' => 'css/app.css']))
      ->landscape(true)
      ->margins(16, 16, 16, 16)
      ->pdf();

    return response()->stream(function () use ($pdf) {
      echo $pdf;
    }, 200, [
      'Content-Type' => 'application/pdf',
      "Content-Disposition" => 'inline;filename="' . $fileName . '.pdf"',
      'Content-Transfer-Encoding: binary'
    ]);
  }
}
