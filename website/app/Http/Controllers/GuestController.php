<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    public function home()
    {
        return view('guest.home');
    }

    public function register()
    {
        return view('guest.register');
    }

    public function registerConfirm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8',
        ]);
        if ($request->password === $request->password_confirmation) {
            app(UserInterface::class)->createUser($request->email, $request->password, $request->name);
            return redirect(route('guest.home'));
        }
        return redirect(route('guest.register'));
    }

    public function login()
    {
        return view('guest.login');
    }

    public function loginConfirm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
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
