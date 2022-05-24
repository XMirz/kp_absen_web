<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
  public function index(Request $request)
  {
    $user = $request->user();
    $user->role = $user->role == 'staff' ? 'Karyawan' : 'Kepala Bagian';
    return Response::json($user, 200);
  }
  public function store(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
      'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
      throw ValidationException::withMessages([
        'email' => ['The provided credentials are incorrect.'],
      ]);
    }

    return response()->json(['token' => $user->createToken($request->device_name)->plainTextToken], 200);
  }
}
