<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    $user = User::where('id', auth()->user()->id)->first();
    $rawStaffs = User::with('roles')->get();
    // Filter dev role
    $staffs = $rawStaffs->filter(function (User $staff) use ($user) {
      if ($staff->roles()->first()->level != 0 || $user->roles()->first()->level == 0) {
        return $staff;
      }
    })->values();
    return Inertia::render('Staff/Index', compact('staffs'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $defaultPassword = 123123123;
    return Inertia::render('Staff/Create', compact('defaultPassword'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $newStaffData = $request->validate([
      'name' => 'required',
      'email' => 'required',
      'nip' => 'required',
      'address' => 'required',
      'gender' => 'required',
      'birthDate' => 'required',
      'role' => 'required',
      'password' => 'required',
    ]);

    $user =  User::create($newStaffData);
    if ($user) {
      $user->assignRole($request->role);
      return redirect()->route('staffs.index');
    }
    return back();
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

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(User $staff)
  {
    // Ambil nama role staff
    $staff->role = $staff->getRoleNames()->toArray()[0];
    return Inertia::render('Staff/Edit', compact('staff'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $staff)
  {
    $newStaffData = $request->validate([
      'name' => 'required',
      'email' => 'required',
      'nip' => 'required',
      'address' => 'required',
      'gender' => 'required',
      'birthDate' => 'required',
    ]);

    // Check if role is changed
    $currentRole = $staff->getRoleNames()->first();
    if ($request->role != $currentRole) {
      $staff->syncRoles([$request->role]);
    }

    $staff->update($newStaffData);
    // return response('', 200);
    return redirect()->route('staffs.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    User::destroy($id);
    return redirect()->route('staffs.index');
  }
}
