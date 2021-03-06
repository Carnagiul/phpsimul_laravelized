<?php

namespace App\Models;

use App\Http\Controllers\UserInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static $morph = 'user';
    public bool $isAdmin = false;
    public bool $adminChecked = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function worldUsers()
    {
        return $this->belongsToMany(WorldUser::class, 'world_user');
    }

    public function permissions()
    {
        return $this->belongsToMany(UserPermission::class);
    }

    public function isAdmin() {
        if ($this->adminChecked === false) {
            $permission = Permission::where('permission', '=', 'administrate-all')->first();
            $this->isAdmin = app(UserInterface::class)->verifyPermissionOfUser($this, $permission);
            $this->adminChecked = true;
        }
        return $this->isAdmin;
    }
}
