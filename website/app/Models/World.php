<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class World extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static $morph = 'world';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'register_at' => 'datetime',
        'open_at' => 'datetime',
        'close_at' => 'datetime',
    ];
    public function worldUsers()
    {
        return $this->belongsToMany(WorldUser::class, 'world_user');
    }

    public function buildings()
    {
        return $this->hasMany(WorldBuilding::class);
    }

    public function ressources() {
        return $this->hasMany(WorldRessource::class);
    }
}
