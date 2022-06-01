<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
}
