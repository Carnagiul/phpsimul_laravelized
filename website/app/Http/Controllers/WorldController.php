<?php

namespace App\Http\Controllers;

use App\Models\World;
use App\Models\WorldUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorldController extends Controller
{
    //
    public function home(World $world) {
        $worldUser = app(WorldInterface::class)->getUserInWorld($world, Auth::user());
        if ($worldUser->nodes->count() == 0) {
            $worldUser = app(WorldInterface::class)->createNodeOnWorldUser($world, $worldUser);
        }
        return view('auth.world.home', ['world' => $world]);
    }

    public function register(World $world) {
        if (app(WorldInterface::class)->userExistInWorld($world, Auth::user())) {
            return redirect()->route('auth.world.home', $world);
        }
        if (app(WorldInterface::class)->canRegisterInWorld($world)) {
            app(WorldInterface::class)->addUserToWorld($world, Auth::user());
            return redirect(route('auth.world.home', $world));
        }
        return dd("You can't register in this world");
    }
}
