<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserInterface extends Controller
{
    public function createUser(String $email, String $password, String $username): User
    {
        $user = new User();
        $user->email = $email;
        $user->name = $username;
        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }

    public function matchUser(String $email, String $password): ?User
    {
        $user = User::where('email', $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        return null;
    }

    public function verifyPermissionOfUser(User $user, Permission $permission): bool
    {
        return UserPermission::where('user_id', $user->id)->where('permission_id', $permission)->exists();
    }

    public function addPermissionToUser(User $user, Permission $permission): UserPermission
    {
        return UserPermission::create(['user_id' => $user->id, 'permission_id' => $permission->id]);
    }



}
