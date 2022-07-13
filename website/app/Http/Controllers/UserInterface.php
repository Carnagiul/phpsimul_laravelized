<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserInterface extends Controller
{
    public function createUser(String $email, String $password)
    {
        $user = new User();
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }

    public function matchUser(String $email, String $password)
    {
        $user = User::where('email', $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        return null;
    }
    //
}
