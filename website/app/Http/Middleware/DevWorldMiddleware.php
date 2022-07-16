<?php

namespace App\Http\Middleware;

use App\Models\World;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class DevWorldMiddleware
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
        if ($world != null) {
            if ($world->is_dev) {
                return $next($request);
            }
        }
        return redirect(url()->previous());
    }
}
