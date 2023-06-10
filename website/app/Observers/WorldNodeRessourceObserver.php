<?php

namespace App\Observers;

use App\Models\WorldNodeRessource;

class WorldNodeRessourceObserver
{
    /**
     * Handle the WorldNodeRessource "created" event.
     *
     * @param  \App\Models\WorldNodeRessource  $worldNodeRessource
     * @return void
     */
    public function created(WorldNodeRessource $worldNodeRessource)
    {
        //
    }

    /**
     * Handle the WorldNodeRessource "updated" event.
     *
     * @param  \App\Models\WorldNodeRessource  $worldNodeRessource
     * @return void
     */
    public function updated(WorldNodeRessource $worldNodeRessource)
    {
        //
    }

    /**
     * Handle the WorldNodeRessource "deleted" event.
     *
     * @param  \App\Models\WorldNodeRessource  $worldNodeRessource
     * @return void
     */
    public function deleted(WorldNodeRessource $worldNodeRessource)
    {
        //
    }

    /**
     * Handle the WorldNodeRessource "restored" event.
     *
     * @param  \App\Models\WorldNodeRessource  $worldNodeRessource
     * @return void
     */
    public function restored(WorldNodeRessource $worldNodeRessource)
    {
        //
    }

    /**
     * Handle the WorldNodeRessource "force deleted" event.
     *
     * @param  \App\Models\WorldNodeRessource  $worldNodeRessource
     * @return void
     */
    public function forceDeleted(WorldNodeRessource $worldNodeRessource)
    {
        //
    }
}
