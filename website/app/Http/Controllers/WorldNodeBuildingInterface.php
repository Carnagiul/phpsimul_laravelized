<?php

namespace App\Http\Controllers;

use App\Models\World;
use App\Models\WorldBuilding;
use App\Models\WorldBuildingEvolution;
use App\Models\WorldNode;
use App\Models\WorldNodeBuilding;
use App\Models\WorldNodeBuildingQueue;

class WorldNodeBuildingInterface extends Controller
{
    public function list(World $world, WorldNode $node) {
        return view('auth.world.node.building.list', ['world' => $world, 'node' => $node, 'building']);
    }

    public function evolve(World $world, WorldNode $node, WorldBuilding $building) {
        $waiting = $node->buildingQueue()->where('world_building_id', $building->id)->get();

        $evolutions = $node->buildings()->where('world_building_id', $building->id)->get()->first();
        $next = $building->evolutions()->where('level', $evolutions->level + ($waiting->count()))->get()->first()->next();
        $valid = true;
        foreach ($next->costs as $cost) {
            $valid = app(WorldNodeInterface::class)->hasEnough($node, $cost);
            if ($valid == false)
                break ;
        }

        if (!$valid) {
            return redirect()->route('auth.world.node.building.list', ['world' => $world->id, 'node' => $node->id])->with('popup-error', "Le batiment " . $building->name . " n'a pas ete place en construction car il manque des ressources");

        }
        foreach ($next->costs as $cost)
            app(WorldNodeInterface::class)->removeRessource($node, $cost);

        $queue = new WorldNodeBuildingQueue();
        $queue->world_node_id = $node->id;
        $queue->world_building_id = $building->id;
        $queue->start_at = now();
        $queue->level = $next->level;
        $queue->remaining = $next->duration;
        $queue->position = $node->buildingQueue->count();
        $queue->save();

        return redirect()->route('auth.world.node.building.list', ['world' => $world->id, 'node' => $node->id])->with('popup-success', "Le batiment " . $building->name . " a ete place en construction");
    }
    //
}
