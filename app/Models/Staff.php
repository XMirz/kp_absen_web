<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
  use HasFactory;
  protected $table = 'users';
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];
  protected $hidden = [
    'password',
    'remember_token',
  ];
}
