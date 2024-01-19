<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorldNodeBuildingQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'world_node_id',
        'world_building_id',
        'level',
        'start_at',
        'remaining',
        'position',
    ];

    public function node() {
        return $this->belongsTo(WorldNode::class, 'world_node_id');
    }

    public function building() {
        return $this->belongsTo(WorldBuilding::class, 'world_building_id');
    }
}
