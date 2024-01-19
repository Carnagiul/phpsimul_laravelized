<?php

namespace App\Observers;

use App\Models\WorldNodeBuildingQueue;

class WorldNodeBuildingQueueObserver
{
    /**
     * Handle the WorldNodeBuildingQueue "created" event.
     *
     * @param  \App\Models\WorldNodeBuildingQueue  $worldNodeBuildingQueue
     * @return void
     */
    public function created(WorldNodeBuildingQueue $worldNodeBuildingQueue)
    {
        //
    }

    /**
     * Handle the WorldNodeBuildingQueue "updated" event.
     *
     * @param  \App\Models\WorldNodeBuildingQueue  $worldNodeBuildingQueue
     * @return void
     */
    public function updated(WorldNodeBuildingQueue $worldNodeBuildingQueue)
    {
        //
    }

    /**
     * Handle the WorldNodeBuildingQueue "deleted" event.
     *
     * @param  \App\Models\WorldNodeBuildingQueue  $worldNodeBuildingQueue
     * @return void
     */
    public function deleted(WorldNodeBuildingQueue $worldNodeBuildingQueue)
    {
        //
    }

    /**
     * Handle the WorldNodeBuildingQueue "restored" event.
     *
     * @param  \App\Models\WorldNodeBuildingQueue  $worldNodeBuildingQueue
     * @return void
     */
    public function restored(WorldNodeBuildingQueue $worldNodeBuildingQueue)
    {
        //
    }

    /**
     * Handle the WorldNodeBuildingQueue "force deleted" event.
     *
     * @param  \App\Models\WorldNodeBuildingQueue  $worldNodeBuildingQueue
     * @return void
     */
    public function forceDeleted(WorldNodeBuildingQueue $worldNodeBuildingQueue)
    {
        //
    }
}
