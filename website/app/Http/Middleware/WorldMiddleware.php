<?php

namespace App\Http\Middleware;

use App\Models\World;
use App\Models\WorldUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class WorldMiddleware
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
        $user = Auth::user();
        $world = $request->route('world');

        $worldUser = WorldUser::where('world_id', '=', $world->id)->where('user_id', '=', $user->id)->get()->first();
        $request->session()->put('world_user', $worldUser);
        View::share('worldUser', $worldUser);

        return $next($request);
    }
}
