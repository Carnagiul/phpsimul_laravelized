<?php

namespace App\Http\Controllers;

use App\Models\World;
use Illuminate\Http\Request;

class WorldAdminController extends Controller
{
    //

    public function home(World $world) {
        return view('auth.world.admin.home', ['world' => $world]);
    }
}
