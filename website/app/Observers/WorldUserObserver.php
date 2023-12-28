<?php

namespace App\Observers;

use App\Http\Controllers\WorldInterface;
use App\Models\WorldNode;
use App\Models\WorldUser;

class WorldUserObserver
{
    /**
     * Handle the WorldUser "created" event.
     *
     * @param  \App\Models\WorldUser  $worldUser
     * @return void
     */
    public function created(WorldUser $worldUser)
    {
        //
        if ($worldUser->nodes->count() == 0) {
            $worldUser = app(WorldInterface::class)->createNodeOnWorldUser($worldUser->world, $worldUser);
        }

    }

    /**
     * Handle the WorldUser "updated" event.
     *
     * @param  \App\Models\WorldUser  $worldUser
     * @return void
     */
    public function updated(WorldUser $worldUser)
    {
        //
    }

    /**
     * Handle the WorldUser "deleted" event.
     *
     * @param  \App\Models\WorldUser  $worldUser
     * @return void
     */
    public function deleted(WorldUser $worldUser)
    {
        //
    }

    /**
     * Handle the WorldUser "restored" event.
     *
     * @param  \App\Models\WorldUser  $worldUser
     * @return void
     */
    public function restored(WorldUser $worldUser)
    {
        //
    }

    /**
     * Handle the WorldUser "force deleted" event.
     *
     * @param  \App\Models\WorldUser  $worldUser
     * @return void
     */
    public function forceDeleted(WorldUser $worldUser)
    {
        //
    }
}
