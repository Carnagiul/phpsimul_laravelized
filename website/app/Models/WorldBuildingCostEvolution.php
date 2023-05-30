<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorldBuildingCostEvolution extends Model
{
    use HasFactory;

    public static $morph = 'world_building_cost_evolution';

    protected $fillable = [
        'world_building_evolution_id',
        'world_ressource_id',
        'amount',
    ];

    public function buildingEvolution()
    {
        return $this->belongsTo(WorldBuildingEvolution::class);
    }

    public function ressource()
    {
        return $this->belongsTo(WorldRessource::class);
    }
}
