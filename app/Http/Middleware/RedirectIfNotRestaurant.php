<?php

namespace App\Http\Middleware;

use App\Models\Restaurant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


use Illuminate\Auth\Middleware\Authenticate;

class RedirectIfNotRestaurant extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */

    public function handle($request, Closure $next, ...$guards)
    {
        if (!Auth::guard('Restaurant')->check()) {
            return redirect()->route('Restaurant.login_form');
        }

        return $next($request);
    }



    // $id_Restaurant = $request->input('id');
    // $Restaurant = Restaurant::find($id_Restaurant);
    // $connected = $Restaurant->connected;
    // if ($connected == false) {
    //     return redirect()->view('Restaurant.login_form');
    // }

    // return $next($request);
}
