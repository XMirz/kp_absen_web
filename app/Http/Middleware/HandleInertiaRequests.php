<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
  /**
   * The root template that is loaded on the first page visit.
   *
   * @var string
   */
  protected $rootView = 'app';

  /**
   * Determine the current asset version.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return string|null
   */
  public function version(Request $request)
  {
    return parent::version($request);
  }

  /**
   * Define the props that are shared by default.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function share(Request $request)
  {
    // Shared data
    $user = User::find(auth()->user()->id);
    $user->roles = $user->getRoleNames()->toArray();
    return array_merge(parent::share($request), [
      'auth' => [
        'user' => $user,
      ],
      'ziggy' => function () {
        return (new Ziggy)->toArray();
      },
    ]);
  }
}
