<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\WorldAdminController;
use App\Http\Controllers\WorldController;
use App\Http\Controllers\WorldNodeBuildingInterface;
use App\Http\Controllers\WorldNodeInterface;
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
        'middleware' => 'world',
    ], function () {
        Route::get('/', [WorldController::class, 'home'])->name('home');
        Route::get('/register', [WorldController::class, 'register'])->name('register');
        Route::group([
            'as' => 'node.',
            'prefix' => 'node/{node}',
            'middleware' => 'worldNode',
        ], function() {
            Route::get('', [WorldNodeInterface::class, 'nodeHome'])->name('home');
            Route::get('nodeRess', [WorldNodeInterface::class, 'nodeRess'])->name('nodeRess');
            Route::get('nodeBuildQueue', [WorldNodeInterface::class, 'nodeBuildQueue'])->name('nodeBuildQueue');
            Route::group([
                'as' => 'building.',
                'prefix' => 'building',
            ], function() {
                Route::get('', [WorldNodeBuildingInterface::class, 'list'])->name('list');
                Route::group([
                    'as' => 'actions.',
                    'prefix' => 'building{building}',
                ], function() {
                    Route::get('evolve', [WorldNodeBuildingInterface::class, 'evolve'])->name('evolve');
                });
            });
            Route::get('building_{building}', [WorldNodeBuildingInterface::class, 'evolve'])->name('building.evolve');
        });
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
            Route::group([
                'as' => 'ressources.',
                'prefix' => 'ressources',
            ], function() {

                Route::get("/", [WorldAdminController::class, 'ressources'])->name('list');
                Route::get("/create", [WorldAdminController::class, 'createNewRessource'])->middleware('dev')->name('create');
                Route::post("/create", [WorldAdminController::class, 'createNewRessourceConfirmation'])->middleware('dev')->name('create.post');
                Route::group([
                    'as' => 'actions.',
                    'prefix' => 'ressource_{ressource}',
                ], function() {
                    Route::get("/", [WorldAdminController::class, 'viewRessource'])->name('view');
                    Route::get("/edit", [WorldAdminController::class, 'editRessource'])->name('edit');
                    Route::post("/edit", [WorldAdminController::class, 'editRessourceConfirmation'])->name('edit.post');
                    Route::get("/delete", [WorldAdminController::class, 'deleteRessource'])->name('delete');
                    Route::post("/delete", [WorldAdminController::class, 'deleteRessourceConfirmation'])->name('delete.post');
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

