 <?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use illuminate\Support\Facades\Auth;

class Restaurant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bool=1;
        if(!Auth::guard('Restaurant')->check()){
            $bool=0;
            return redirect()->route('Restaurant.login_form')->with('error','you have to login first');
        }
        return $next($request);
    }
}
