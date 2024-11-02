<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserpageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $useractivity = UserActivity::where('user_id', Auth::user()->id)->where('ip_address', request()->ip())->latest()->first();
            if (empty($useractivity)) {
                UserActivity::create([
                    'user_id'     => Auth::user()->id,
                    'page_name'   => request()->url(),
                    'login_time'  => Carbon::now(),
                    'logout_time' => NULL,
                    'ip_address'  => request()->ip(),
                ]);
            } else {
                $useractivity->page_name = request()->url();
                $useractivity->update();
            }
        }
        return $next($request);
    }
}
