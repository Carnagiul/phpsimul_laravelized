<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserPermission extends Pivot
{
    //

    public static $morph = "user_permission";

    protected $fillable = [
        'permission_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
