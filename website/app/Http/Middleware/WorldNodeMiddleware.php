<?php

namespace App\Http\Middleware;

use App\Http\Controllers\WorldNodeInterface;
use App\Models\WorldNode;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorldNodeMiddleware
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
        $world = $request->route('world');
        $node = $request->route('node');
        $worldUser = $request->session()->get('world_user');

        if (app(WorldNodeInterface::class)->canAcces($node, $worldUser) == false) {
            return redirect(route('auth.world.home', $world));
        }

        return $next($request);
    }
}
