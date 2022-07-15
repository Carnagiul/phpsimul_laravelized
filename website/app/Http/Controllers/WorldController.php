<?php

namespace App\Http\Controllers;

use App\Models\World;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorldController extends Controller
{
    //
    public function home() {
        dd("GG");
    }

    public function register(World $world) {
        if (app(WorldInterface::class)->userExistInWorld($world, Auth::user())) {
            return redirect()->route('world.home', $world);
        }
        if (app(WorldInterface::class)->canRegisterInWorld($world)) {
            app(WorldInterface::class)->addUserToWorld($world, Auth::user());
            return redirect(route('auth.world.home', $world));
        }
        return dd("You can't register in this world");
    }
}
