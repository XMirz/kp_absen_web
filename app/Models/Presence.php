<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
  use HasFactory;
  protected $guarded = ['id'];
  protected $casts = [
    'inArea' => 'boolean',
    'checkInTime' => 'datetime',
    'checkOutTime' => 'datetime',
    'checkInDistance' => 'string',
    'checkOutDistance' => 'string',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }


  // public function getTodayStaffPresences(){
  //   $staffs = User::all();
  //   $

  // }

}
