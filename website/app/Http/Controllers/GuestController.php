<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

    public function register()
    {
        return view('welcome');
    }

    public function registerConfirm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirm' => 'required|min:8',
        ]);
        if ($request->password === $request->password_confirm) {
            app(UserInterface::class)->createUser($request->email, $request->password);

            return redirect(route('guest.home'));
        }
        return view('welcome');
    }

    public function login()
    {
        return view('welcome');
    }

    public function loginConfirm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
        $user = app(UserInterface::class)->matchUser($request->email, $request->password);
        if ($user instanceof User) {
            Auth::login($user);
            return redirect(route('auth.home'));
        }
        return redirect(route('guest.login', ['error' => 'Invalid email or password']));
    }

    public function forget()
    {
        return view('welcome');
    }

    public function forgetConfirm()
    {
        return view('welcome');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('guest.home', ['error' => 'You have been logged out']));
    }
    //
}
