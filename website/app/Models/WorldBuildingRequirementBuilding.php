<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorldBuildingRequirementBuilding extends Model
{
    use HasFactory;

    protected $fillable = [
        'world_building_id',
        'required_world_building_id',
        'level'
    ];

    public function worldBuilding()
    {
        return $this->belongsTo(WorldBuilding::class, 'world_building_id');
    }

    public function requiredWorldBuilding()
    {
        return $this->belongsTo(WorldBuilding::class, 'required_world_building_id');
    }
}
