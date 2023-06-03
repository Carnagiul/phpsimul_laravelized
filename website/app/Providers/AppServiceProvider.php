<?php

namespace App\Providers;

use App\Models\User;
use App\Models\World;
use App\Models\WorldBuilding;
use App\Models\WorldNode;
use App\Models\WorldRessource;
use App\Models\WorldUser;
use App\Observers\WorldUserObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Relation::morphMap([
            User::$morph => User::class,
            WorldUser::$morph => WorldUser::class,
            WorldBuilding::$morph => WorldBuilding::class,
            WorldNode::$morph => WorldNode::class,
            WorldRessource::$morph => WorldRessource::class,
            World::$morph => World::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        WorldUser::observe(WorldUserObserver::class);
    }
}
