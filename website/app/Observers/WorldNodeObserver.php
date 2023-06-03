<?php

namespace App\Observers;

use App\Models\WorldNode;

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
