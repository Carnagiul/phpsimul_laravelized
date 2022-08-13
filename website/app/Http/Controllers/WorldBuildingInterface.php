<?php

namespace App\Http\Controllers;

use App\Models\World;
use App\Models\WorldBuilding;
use App\Models\WorldBuildingCostEvolution;
use App\Models\WorldBuildingEvolution;
use App\Models\WorldRessource;

class WorldBuildingInterface extends Controller
{
    public function createNewBuilding(World $world, String $name, String $description, int $maxLevel, int $defaultLevel)
    {
        $building = new WorldBuilding();
        $building->world_id = $world->id;
        $building->name = $name;
        $building->description = $description;
        $building->max_level = $maxLevel;
        $building->default_level = $defaultLevel;
        $building->save();

        return $building;
    }

    public function updateOldBuilding(WorldBuilding $building, array $datas)
    {
        if ($datas['name'] != null && $datas['name'] != $building->name)
            $building->name = $datas['name'];
        if ($datas['description'] != null && $datas['description'] != $building->description)
            $building->description = $datas['description'];
        if ($datas['max_level'] != null && $datas['max_level'] != $building->max_level)
            $building->max_level = $datas['max_level'];
        if ($datas['default_level'] != null && $datas['default_level'] != $building->default_level)
            $building->default_level = $datas['default_level'];
        $building->save();

        return $building;
    }

    public function buildingExistInWorld(World $world, String $name)
    {
        return WorldBuilding::where('world_id', $world->id)->where('name', $name)->exists();
    }

    public function deleteOldWorldBuildingEvolution(WorldBuilding $building)
    {
        $building->evolutions()->delete();
    }

    public function deleteOldWorldBuildingCostEvolution(WorldBuildingEvolution $building_evolution)
    {
        $building_evolution->costs()->delete();
    }

    public function createNewWorldBuildingEvolution(WorldBuilding $building, array $time, array $ressources)
    {
        $this->deleteOldWorldBuildingEvolution($building);

        foreach ($ressources as $key => $value) {
            $ressources[$key]['model'] = WorldRessource::where('id', $value['id'])->first();
        }
        for ($i = 0; $i < $building->max_level; $i++) {
            if ($i > 0 && $time['evolution'] > 0) {
                $time['base'] += $time['base'] * ($time['evolution'] / 100);
            }
            $evolution = new WorldBuildingEvolution();
            $evolution->world_building_id = $building->id;
            $evolution->level = $i;
            $evolution->duration = $time['base'];
            $evolution->save();
            foreach ($ressources as $ressource) {
                $object = $this->createNewWorldBuildingCostEvolution($evolution, $ressource['model'], $ressource['amount'], $ressource['evolution']);
                $ressource['amount'] = $object->amount;
            }
        }

        return $evolution;
    }

    public function createNewWorldBuildingCostEvolution(WorldBuildingEvolution $building_evolution, WorldRessource $ressource, int $amountCost, int $evolutionCost)
    {
        $this->deleteOldWorldBuildingCostEvolution($building_evolution);
        $costEvolution = new WorldBuildingCostEvolution();
        $costEvolution->world_building_evolution_id = $building_evolution->id;
        $costEvolution->world_ressource_id = $ressource->id;
        if ($building_evolution->level > 0 && $evolutionCost > 0) {
            $amountCost += $amountCost * ($evolutionCost / 100);
        }
        $costEvolution->amount = $amountCost;
        $costEvolution->save();

        return $costEvolution;
    }
}
