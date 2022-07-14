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

    public function worldUsers()
    {
        return $this->belongsToMany(WorldUser::class);
    }

    public function buildings()
    {
        return $this->hasMany(WorldBuilding::class);
    }
}
