<?php

namespace App\Observers;

use App\Http\Controllers\WorldNodeRessourceInterface;
use App\Models\WorldNode;
use App\Models\WorldNodeBuilding;
use App\Models\WorldNodeRessource;
use App\Models\WorldRessource;
use Illuminate\Support\Facades\Schema;

class WorldNodeObserver
{
    /**
     * Handle the WorldNode "created" event.
     *
     * @param  \App\Models\WorldNode  $worldNode
     * @return void
     */
    public function created(WorldNode $worldNode)
    {
        if (Schema::hasTable('world_node_buildings')) {
            foreach ($worldNode->world->buildings as $building) {
                WorldNodeBuilding::create([
                    'world_node_id' => $worldNode->id,
                    'world_building_id' => $building->id,
                    'level' => $building->default_level,
                ]);
            }
        }

        if (Schema::hasTable('world_node_ressources')) {
            app(WorldNodeRessourceInterface::class)->generateDefaultRessourceOnVillage($worldNode);
            // app(App\Http\Controllers\WorldNodeRessourceInterface::class)->generateDefaultRessourceOnVillage($node);
        }

            //
    }

    /**
     * Handle the WorldNode "updated" event.
     *
     * @param  \App\Models\WorldNode  $worldNode
     * @return void
     */
    public function updated(WorldNode $worldNode)
    {
        //
    }

    /**
     * Handle the WorldNode "deleted" event.
     *
     * @param  \App\Models\WorldNode  $worldNode
     * @return void
     */
    public function deleted(WorldNode $worldNode)
    {
        //
    }

    /**
     * Handle the WorldNode "restored" event.
     *
     * @param  \App\Models\WorldNode  $worldNode
     * @return void
     */
    public function restored(WorldNode $worldNode)
    {
        //
    }

    /**
     * Handle the WorldNode "force deleted" event.
     *
     * @param  \App\Models\WorldNode  $worldNode
     * @return void
     */
    public function forceDeleted(WorldNode $worldNode)
    {
        //
    }
}
