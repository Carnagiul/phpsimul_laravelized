<?php

namespace App\Http\Controllers;

use App\Models\World;
use App\Models\WorldRessource;

class WorldRessourceInterface extends Controller
{
    public function createNewRessource(World $world, String $name, String $description)
    {
        $ressource = new WorldRessource();
        $ressource->world_id = $world->id;
        $ressource->name = $name;
        $ressource->description = $description;
        $ressource->save();

        return $ressource;
    }

    public function ressourceExistInWorld(World $world, String $name)
    {
        return WorldRessource::where('world_id', $world->id)->where('name', $name)->exists();
    }

    public function updateOldRessource(WorldRessource $ressource, array $datas)
    {
        if ($datas['name'] != null && $datas['name'] != $ressource->name)
            $ressource->name = $datas['name'];
        if ($datas['description'] != null && $datas['description'] != $ressource->description)
            $ressource->description = $datas['description'];
        $ressource->save();

        return $ressource;
    }
}
