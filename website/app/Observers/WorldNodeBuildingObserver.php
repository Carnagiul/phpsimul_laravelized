<?php

namespace App\Observers;

use App\Models\WorldNodeBuilding;

class WorldNodeBuildingObserver
{
    /**
     * Handle the WorldNodeBuilding "created" event.
     *
     * @param  \App\Models\WorldNodeBuilding  $worldNodeBuilding
     * @return void
     */
    public function created(WorldNodeBuilding $worldNodeBuilding)
    {
        //
    }

    /**
     * Handle the WorldNodeBuilding "updated" event.
     *
     * @param  \App\Models\WorldNodeBuilding  $worldNodeBuilding
     * @return void
     */
    public function updated(WorldNodeBuilding $worldNodeBuilding)
    {
        //
    }

    /**
     * Handle the WorldNodeBuilding "deleted" event.
     *
     * @param  \App\Models\WorldNodeBuilding  $worldNodeBuilding
     * @return void
     */
    public function deleted(WorldNodeBuilding $worldNodeBuilding)
    {
        //
    }

    /**
     * Handle the WorldNodeBuilding "restored" event.
     *
     * @param  \App\Models\WorldNodeBuilding  $worldNodeBuilding
     * @return void
     */
    public function restored(WorldNodeBuilding $worldNodeBuilding)
    {
        //
    }

    /**
     * Handle the WorldNodeBuilding "force deleted" event.
     *
     * @param  \App\Models\WorldNodeBuilding  $worldNodeBuilding
     * @return void
     */
    public function forceDeleted(WorldNodeBuilding $worldNodeBuilding)
    {
        //
    }
}
