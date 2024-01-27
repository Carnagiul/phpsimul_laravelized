<?php

namespace App\Http\Controllers;

use App\Models\WorldNode;
use App\Models\WorldNodeRessource;
use App\Models\WorldRessource;

class WorldNodeRessourceInterface extends Controller
{
    //

    public function worldRessourceExistOnNode(WorldNode $node, WorldRessource $ressource) {
        $ressources = $node->ressources;
        foreach ($ressources as $ress) {
            if ($ress->world_ressource_id == $ressource->id) {
                return true;
            }
        }
        return false;
    }

    public function generateDefaultRessourceOnVillage(WorldNode $node) {
        foreach ($node->world->ressources as $ressource) {
            echo $ressource->id . " " . $ressource->name . " " . $ressource->default_amount;
            $ressExist = $this->worldRessourceExistOnNode($node, $ressource);
            if ($ressExist) {
                echo " already exist\n";
            } else {
                if ($ressource->type == 'node') {
                    echo " not exist and so we created id\n";
                    $ressourceCreated = new WorldNodeRessource([
                        'world_node_id' => $node->id,
                        'world_ressource_id' => $ressource->id,
                        'amount' => $ressource->default_amount,
                        'prod' => $ressource->default_prod,
                        'storage' => $ressource->default_storage,
                    ]);
                    $ressourceCreated->save();
                }
            }
        }
    }
}
