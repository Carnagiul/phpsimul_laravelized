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
        'description',
    ];

    public function world() {
        return $this->belongsTo(World::class);
    }
}
