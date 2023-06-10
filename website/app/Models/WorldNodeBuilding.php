<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorldNodeBuilding extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static $morph = 'world_node_building';

    protected $fillable = [
        'world_node_id',
        'world_building_id',
        'level',
    ];

    protected $casts = [
        'level' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function node()
    {
        return $this->belongsTo(WorldNode::class);
    }

    public function building()
    {
        return $this->belongsTo(WorldBuilding::class);
    }
}
