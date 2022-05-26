<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
  public function index(Request $request)
  {
    $user = $request->user();
    $role = User::where('id', $user->id)->first()->roles()->get();
    $user->role = $role == 'chief' ? 'Kepala Bagian' : 'Pegawai';
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

  // Handle update password
  public function update(Request $request)
  {
    if (Hash::check($request->oldPassword, Auth::user()->password) == true) {
      $user = Auth::user();
      $user->password = Hash::make($request->newPassword);
      $user->update();
      // $user->tokens()->delete();
      return response()->json([
        'status' => 'success',
        'statusCode' => 200,
      ], 200);
    }
    return response()->json([
      'statusCode' => 403,
      'status' => 'wrong-old-password',
    ], 200);
  }
  public function destroy(Request $request)
  {
    $request->user()->currentAccessToken()->delete();
    return response()->json([], 200);
  }
}
