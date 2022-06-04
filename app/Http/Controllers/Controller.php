<?php

namespace App\Http\Controllers;

use Arr;
use Carbon\Carbon;
use Date;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Laravel\Sail\Console\PublishCommand;
use Nette\Utils\Arrays;
use Nette\Utils\Json;
use Str;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function getHolidaysInMonth($year, $month)
  {
    $holidayJson = file_get_contents(public_path() . '/data/holiday/' . $year . '.json');
    $yearHoliday = Json::decode($holidayJson);
    // Month Holiday
    $holiday = Arr::where($yearHoliday, function ($day, $index) use ($year, $month) {
      return Str::contains($day->holiday_date, "$year-$month");
    });
    return $holiday;
  }

  public function isHoliday(Carbon $date)
  {
    /** $monthHolidays  */
    $monthHolidays =  $this->getHolidaysInMonth($date->format('Y'), $date->format('m'));
    $isHoliday = Arrays::some($monthHolidays, function ($day, $index) use ($date) {
      // @var $day is an object ,not an array
      $holidayDate =  Carbon::createFromFormat('Y-m-d', $day->holiday_date);
      $isSameDay = $holidayDate->isSameDay($date);
      $isNationalHoliday = $day->is_national_holiday;
      return $isSameDay && $isNationalHoliday;
    });
    return $isHoliday;
  }
}
