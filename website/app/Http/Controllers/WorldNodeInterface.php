<?php

namespace App\Http\Controllers;

use App\Models\World;
use App\Models\WorldBuilding;
use App\Models\WorldBuildingCostEvolution;
use App\Models\WorldBuildingEvolution;
use App\Models\WorldNode;
use App\Models\WorldRessource;
use App\Models\WorldUser;
use Illuminate\Support\Facades\Auth;

class WorldNodeInterface extends Controller
{
    public function canAcces(WorldNode $node, WorldUser $user) {
        if ($node->owner->id == $user->id) {
            return true;
        }
        return false;
    }

    public function nodeHome(World $world, WorldNode $node) {
        $worldUser = app(WorldInterface::class)->getUserInWorld($world, Auth::user());
        return view('auth.world.node.view', ['world' => $world, 'node' => $node]);
    }

    public function hasEnough(WorldNode $node, WorldBuildingCostEvolution $cost) {
        $ress = $node->ressources()->where('world_ressource_id', $cost->world_ressource_id)->get()->first();
        if ($ress == null) {
            return false;
        }
        return ($ress->amount >= $cost->amount);
    }

    public function removeRessource(WorldNode $node, WorldBuildingCostEvolution $cost) {
        $ress = $node->ressources()->where('world_ressource_id', $cost->world_ressource_id)->get()->first();
        if ($ress == null) {
            return false;
        }
        $ress->amount -= $cost->amount;
        $ress->save();
    }

    public function nodeRess(World $world, WorldNode $node) {
        $actual = $node->ressources()->with('ressource')->get();
        $node->buildings->each(function($item) use (&$actual) {
            $evolution = WorldBuildingEvolution::where('world_building_id', $item->world_building_id)->where('level', $item->level)->get()->first();
            foreach ($evolution->productions as $prod) {
                if ($prod->amount_per_hour > 0) {
                    foreach ($actual as $key => $value) {
                        if ($value->world_ressource_id == $prod->world_ressource_id) {
                            $actual[$key]['prod'] += $prod->amount_per_hour;
                        }
                    }
                    // $actual
                }
            }
        });
        return $actual;
    }
}
