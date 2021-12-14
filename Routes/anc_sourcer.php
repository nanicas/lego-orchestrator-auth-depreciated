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

$ancConfig = Helper::readConfig();
$ancMiddlewares = $ancConfig['middlewares'];

Route::prefix($ancConfig['route_group'])->group(function () use ($ancConfig, $ancMiddlewares) {

    Route::prefix($ancConfig['api_group'])
        ->middleware([$ancMiddlewares['authenticable_middleware']])
        ->group(function () use ($ancConfig) {

            Route::post('/login/generateTempAuthByToken',
                [LoginController::class, 'generateTempAuthByToken'])->name('generateTempAuthByToken');

            Route::prefix('/users')->group(function () use ($ancConfig) {
                Route::get('/{id}', [$ancConfig['user_api'], 'find']);
            });
    });

    Route::middleware(['web'])->group(function () {

        Route::prefix('/login')->group(function () {

            Route::post('/generateTempAuthInSourcer',
                [LoginController::class, 'generateTempAuthInSourcer'])->name('generateTempAuthInSourcer');

            Route::get('/generateTokenByTemp',
                [LoginController::class, 'generateTokenByTemp'])->name('generateTokenByTemp');

            Route::get('/tryRegenerateToken',
                [LoginController::class, 'tryRegenerateToken'])->name('tryRegenerateToken');

            Route::get('/changeSessionByIdentifier',
                [LoginController::class, 'changeSessionByIdentifier'])->name('changeSessionByIdentifier');
        });
    });

    Route::post('/authorization/verify',
        [AuthorizationController::class, 'verify']);
});
