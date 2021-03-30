<?php 

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()) {
            $master_type = isset($_GET['master_type']) ? $_GET['master_type'] : '';
            if(check_permission(Auth::user()->id, Route::currentRouteName(), $master_type)) {
                return $next($request);
            }else {
                return redirect('/')->with('permissionError', 'You are not allowed to access this url.');
            }
        }else {
            return $next($request);
        }
        
    }
}
