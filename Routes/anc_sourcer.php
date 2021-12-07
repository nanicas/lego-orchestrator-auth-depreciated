<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Application;
use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Controllers\AuthorizationController;
use App\Http\Controllers\Auth\LoginController;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */



Route::get('/applications',
    function () {
        return response()->json(Application::get());
    });

$config = Helper::readConfig();

Route::prefix($config['route_prefix'])->group(function () use ($config) {

    Route::middleware([$config['authenticable_middleware']])->prefix('/users')->group(function () use ($config) {
        Route::get('/{id}', [$config['user_api'], 'find']);
    });

    Route::middleware(['web'])->prefix('/login')->group(function () {
        Route::get('/generateTokenByTemp',
            [LoginController::class, 'generateTokenByTemp'])->name('generateTokenByTemp');

        Route::get('/tryRegenerateToken',
            [LoginController::class, 'tryRegenerateToken'])->name('tryRegenerateToken');

        Route::get('/changeSessionByIdentifier',
            [LoginController::class, 'changeSessionByIdentifier'])->name('changeSessionByIdentifier');
    });

    Route::post('/authorization/verify',
        [AuthorizationController::class, 'verify']);
});
