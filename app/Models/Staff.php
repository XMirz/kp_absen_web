<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
  use HasFactory, SoftDeletes;
  protected $table = 'users';
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];
  protected $hidden = [
    'password',
    'remember_token',
  ];
}
