<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;
use Jenssegers\Agent\Facades\Agent;
use Torann\GeoIP\Facades\GeoIP;
use Illuminate\Support\Facades\Redis;
class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            $user = Auth::user();

            $userActivity = new UserActivity([
                'userid' => $user->userid,
                'browser' => Agent::browser(),
                'device' => Agent::device(),
                'location' => GeoIP::getLocation()->city,
                'login_time' => now(),
            ]);

            $userActivity->save();
        }

        return $response;
    }
}
