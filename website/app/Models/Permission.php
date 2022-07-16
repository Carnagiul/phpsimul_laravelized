<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public static $morph = 'permission';

    protected $fillable = [
        'permission',
    ];

    public function users()
    {
        return $this->belongsToMany(UserPermission::class);
    }
}
