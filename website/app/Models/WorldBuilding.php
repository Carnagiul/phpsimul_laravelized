<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorldBuilding extends Model
{
    use HasFactory;

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
}
