<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\WorldAdminController;
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
        Route::group([
            'as' => 'admin.',
            'prefix' => 'admin',
            'middleware' => ['admin'],
        ], function () {
            Route::get("/", [WorldAdminController::class, 'home'])->name('home');
            Route::group([
                'as' => 'buildings.',
                'prefix' => 'buildings',
            ], function () {
                Route::get("/", [WorldAdminController::class, 'buildings'])->name('list');
                Route::get("/create", [WorldAdminController::class, 'createNewBuilding'])->middleware('dev')->name('create');
                Route::post("/create", [WorldAdminController::class, 'createNewBuildingConfirmation'])->middleware('dev')->name('create.post');
                Route::group([
                    'as' => 'actions.',
                    'prefix' => 'building_{building}',
                ], function() {
                    Route::get("/", [WorldAdminController::class, 'viewBuilding'])->name('view');
                    Route::get("/edit", [WorldAdminController::class, 'editBuilding'])->name('edit');
                    Route::post("/edit", [WorldAdminController::class, 'editBuildingConfirmation'])->name('edit.post');
                    Route::get("/delete", [WorldAdminController::class, 'deleteBuilding'])->name('delete');
                    Route::post("/delete", [WorldAdminController::class, 'deleteBuildingConfirmation'])->name('delete.post');
                    // Route::get("/updateTimer", [WorldAdminController::class, 'updateBuildingTimer'])->name('updateTimer');
                    // Route::post("/updateTimer", [WorldAdminController::class, 'updateBuildingTimerConfirmation'])->name('updateTimer.post');
                    // Route::get("/updateCost", [WorldAdminController::class, 'updateBuildingTimer'])->name('updateCost');
                    // Route::post("/updateCost", [WorldAdminController::class, 'updateBuildingTimerConfirmation'])->name('updateCost.post');
                    // Route::get("/updateProd", [WorldAdminController::class, 'updateBuildingTimer'])->name('updateProd');
                    // Route::post("/updateProd", [WorldAdminController::class, 'updateBuildingTimerConfirmation'])->name('updateProd.post');
                    // Route::get("/updateStorage", [WorldAdminController::class, 'updateBuildingTimer'])->name('updateStorage');
                    // Route::post("/updateStorage", [WorldAdminController::class, 'updateBuildingTimerConfirmation'])->name('updateStorage.post');
                    // Route::get("/updateRequirement", [WorldAdminController::class, 'updateBuildingTimer'])->name('updateRequirement');
                    // Route::post("/updateRequirement", [WorldAdminController::class, 'updateBuildingTimerConfirmation'])->name('updateRequirement.post');
                });
            });
        });
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

