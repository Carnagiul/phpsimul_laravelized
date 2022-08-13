<?php

namespace App\Http\Controllers;

use App\Models\World;
use App\Models\WorldBuilding;
use App\Models\WorldRessource;
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

    public function editBuilding(World $world, WorldBuilding $building) {
        return view('auth.world.admin.buildings.create', ['world' => $world, 'building' => $building]);
    }

    public function editBuildingConfirmation(Request $request, World $world, WorldBuilding $building) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'max_level' => 'required|integer|min:0',
            'min_level' => 'required|integer|min:0',
            'default_level' => 'required|integer|min:0',
        ]);
        $building = app(WorldBuildingInterface::class)->updateOldBuilding($building, $request->all());
        return redirect(route('auth.world.admin.buildings.actions.view', ['world' => $world->id, 'building' => $building->id]));
    }

    public function viewBuilding(World $world, WorldBuilding $building) {
        dd([$world, $building]);
    }

    public function ressources(World $world) {
        $world->load('ressources');
        return view('auth.world.admin.ressources.list', ['world' => $world]);
    }

    public function createNewRessource(World $world) {
        return view('auth.world.admin.ressources.create', ['world' => $world]);
    }

    public function createNewRessourceConfirmation(Request $request, World $world) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
        ]);
        if (app(WorldRessourceInterface::class)->ressourceExistInWorld($world, $request->name)) {
            return url()->previous();
        }
        $ressource = app(WorldRessourceInterface::class)->createNewRessource($world, $request->name, $request->description);
        return redirect(route('auth.world.admin.ressources.actions.view', ['world' => $world->id, 'ressource' => $ressource->id]));
    }

    public function editRessource(World $world, WorldRessource $ressource) {
        return view('auth.world.admin.ressources.create', ['world' => $world, 'ressource' => $ressource]);
    }

    public function editRessourceConfirmation(Request $request, World $world, WorldRessource $ressource) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
        ]);
        $ressource = app(WorldRessourceInterface::class)->updateOldRessource($ressource, $request->all());
        return redirect(route('auth.world.admin.ressources.actions.view', ['world' => $world->id, 'ressource' => $ressource->id]));
    }

    public function viewRessource(World $world, WorldRessource $ressource) {
        dd([$world, $ressource]);
    }

}
