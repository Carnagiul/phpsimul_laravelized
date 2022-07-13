<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'middleware' => ['auth'],
    'as' => 'auth.',
    'prefix' => 'web',
], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
    Route::get('/logout', function () {
        Auth::logout();
        return redirect(route('guest.home'));
    })->name('logout');
});


Route::group([
    'middleware' => ['guest'],
    'as' => 'guest.',
], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
    Route::get('/register', function () {
        return view('welcome');
    })->name('register');
    Route::post('/register', function () {
        return view('welcome');
    });
    Route::get('/login', function () {
        return view('welcome');
    })->name('login');
    Route::post('/login', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect(route('auth.home'));
        }
        return view('welcome');
    })->name('login.post');
    Route::get('/forget', function () {
        return view('welcome');
    });
    Route::post('/forget', function () {
        return view('welcome');
    });
});
