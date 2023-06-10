<?php

namespace App\Http\Middleware;

use App\Models\World;
use App\Models\WorldBuilding;
use App\Models\WorldNode;
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

        $worldUser = WorldUser::where('world_id', '=', $world->id)->where('user_id', '=', $user->id)->with(['nodes', 'nodes.buildings'])->get()->first();
        $request->session()->put('world_user', $worldUser);
        View::share('worldUser', $worldUser);
        view::share('world', $world);
        if ($worldUser != null) {
            view::share('nodes',
            WorldNode::where([
                ['world_id', '=', $world->id],
                ['owner_type', '=', WorldUser::$morph],
                ['owner_id', '=', $worldUser->id]
            ])->with([
                'buildings'
            ])->get());
        }

        View::share('ressources', $world->ressources);
        View::share('buildings', WorldBuilding::where('world_id', '=', $world->id)->with(['evolutions', 'evolutions.costs', 'evolutions.productions', 'evolutions.storages'])->get());

        return $next($request);
    }
}
