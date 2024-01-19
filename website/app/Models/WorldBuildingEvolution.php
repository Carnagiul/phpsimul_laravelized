<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorldBuildingEvolution extends Model
{
    use HasFactory;


    public static $morph = 'world_building_evolution';

    protected $fillable = [
        'world_building_id',
        'level',
        'duration',
    ];

    public function building()
    {
        return $this->belongsTo(WorldBuilding::class);
    }

    public function costs() {
        return $this->hasMany(WorldBuildingCostEvolution::class);
    }

    public function storages() {
        return $this->hasMany(WorldBuildingStorageEvolution::class);
    }

    public function productions() {
        return $this->hasMany(WorldBuildingProductionEvolution::class);
    }

    public function next() {
        return WorldBuildingEvolution::where('world_building_id', $this->world_building_id)->where('level', $this->level + 1)->get()->first();
    }
}
