<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\WorldController;
use App\Models\World;
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
        return view('auth.home');
    })->name('home');
    Route::get('/logout', [GuestController::class, 'logout'])->name('logout');
    Route::group([
        'as' => 'world.',
        'prefix' => 'world{world}',
    ], function () {
        Route::get('/', [WorldController::class, 'home'])->name('home');
        Route::get('/register', [WorldController::class, 'register'])->name('register');
    });
});


Route::group([
    'middleware' => ['guest'],
    'as' => 'guest.',
], function () {
    Route::get('/', [GuestController::class, 'home'])->name('home');
    Route::get('/register', [GuestController::class, 'register'])->name('register');
    Route::post('/register', [GuestController::class, 'registerConfirm'])->name('register.post');
    Route::get('/login', [GuestController::class, 'login'])->name('login');
    Route::post('/login', [GuestController::class, 'loginConfirm'])->name('login.post');
    Route::get('/forget', [GuestController::class, 'forget'])->name('forget');
    Route::post('/forget', [GuestController::class, 'forgetConfirm'])->name('forget.post');
});

