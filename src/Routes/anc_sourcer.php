<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Application;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Controllers\AuthorizationController;
use Zevitagem\LegoAuth\Controllers\ApplicationController;
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

Route::prefix($ancConfig['package'])->group(function () use ($ancConfig, $ancMiddlewares) {

    Route::prefix($ancConfig['api_group'])
        ->middleware([$ancMiddlewares['authenticable_middleware']])
        ->group(function () use ($ancConfig) {

            Route::post('/login/generateTempAuthByToken',
                [LoginController::class, 'generateTempAuthByToken'])->name('generateTempAuthByToken');

            Route::prefix('/users')->group(function () use ($ancConfig) {
                Route::get('/{id}', [$ancConfig['user_api'], 'find']);
            });

            Route::prefix('/config_users')->group(function () use ($ancConfig) {
                Route::get('/{userId}/{slug}', [$ancConfig['config_user_api'], 'getByUserAndSlug']);
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

    Route::post('/authorization/verify', [AuthorizationController::class, 'verify']);
    Route::get('/application/{app}/slugs', [ApplicationController::class, 'slugs'])->name('slugs');
});
