<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorldRessource extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static $morph = 'world_ressource';

    protected $fillable = [
        'world_id',
        'name',
        'type',
        'description',
        'default_amount',
    ];

    public function world() {
        return $this->belongsTo(World::class);
    }

    public function nodes() {
        return $this->hasMany(WorldNodeRessource::class);
    }
}
