<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorldNodeRessource extends Model
{
    use HasFactory;

    public static $morph = 'world_node_ressource';

    protected $fillable = [
        'world_node_id',
        'world_ressource_id',
        'amount',
        'storage',
        'prod',
    ];

    protected $casts = [
        'amount' => 'float',
        'storage' => 'float',
        'prod' => 'float',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function node() {
        return $this->belongsTo(WorldNode::class);
    }

    public function ressource() {
        return $this->belongsTo(WorldRessource::class);
    }
}
