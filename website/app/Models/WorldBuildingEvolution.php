<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorldBuildingEvolution extends Model
{
    use HasFactory;

    public static $morph = 'world_building_evolution';
    public function building()
    {
        return $this->belongsTo(WorldBuilding::class);
    }

    public function costs()
    {
        return $this->hasMany(WorldBuildingCostEvolution::class);
    }
}
