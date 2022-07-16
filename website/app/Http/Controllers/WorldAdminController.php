<?php

namespace App\Http\Controllers;

use App\Models\World;
use App\Models\WorldBuilding;
use Illuminate\Http\Request;

class WorldAdminController extends Controller
{
    //

    public function home(World $world) {
        return view('auth.world.admin.home', ['world' => $world]);
    }

    public function buildings(World $world) {
        $world->load('buildings');
        return view('auth.world.admin.buildings.list', ['world' => $world]);
    }

    public function createNewBuilding(World $world) {
        return view('auth.world.admin.buildings.create', ['world' => $world]);
    }

    public function createNewBuildingConfirmation(Request $request, World $world) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'max_level' => 'required|integer|min:0',
            'min_level' => 'required|integer|min:0',
            'default_level' => 'required|integer|min:0',
        ]);
        if (app(WorldBuildingInterface::class)->buildingExistInWorld($world, $request->name)) {
            return url()->previous();
        }
        $building = app(WorldBuildingInterface::class)->createNewBuilding($world, $request->name, $request->description, $request->max_level, $request->default_level);
        return redirect(route('auth.world.admin.buildings.actions.view', ['world' => $world->id, 'building' => $building->id]));
    }

    public function viewBuilding(World $world, WorldBuilding $building) {
        dd([$world, $building]);
        // return view('auth.world.admin.buildings.view', ['world' => $world, 'building' => $building]);
    }
}
