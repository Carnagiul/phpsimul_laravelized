<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class WorldUser extends Pivot
{
    //
    public static $morph = "world_user";

    public function world()
    {
        return $this->belongsTo(World::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nodes()
    {
        return $this->morphMany(WorldNode::class, "owner");
    }
}
