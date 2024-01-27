<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorldBuilding extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static $morph = 'world_building';

    protected $fillable = [
        'world_id',
        'name',
        'description',
        'max_level',
        'default_level',
        'min_level'
    ];

    public function world()
    {
        return $this->belongsTo(World::class);
    }

    public function evolutions()
    {
        return $this->hasMany(WorldBuildingEvolution::class);
    }

    public function inQueue() {
        return $this->hasMany(WorldNodeBuildingQueue::class, 'world_building_id');
    }

    public function buildingRequirements()
    {
        return $this->hasMany(WorldBuildingRequirementBuilding::class);
    }
}
