<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SystemController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/v1/login', [AuthController::class, 'login']);
Route::post('/v1/register', [AuthController::class, 'register']);
Route::get('/v1/user', function() {
    return User::all();
});

Route::get('/v1/user/{user}', [AuthController::class, 'user']);
Route::put('/v1/user/{user}', [UserController::class, 'update']);

Route::get('/v1/rol/{rol}', [RolController::class, 'show']);


/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/v1/logout', [AuthController::class, 'logout']);
    Route::get('/v1/rol', [RolController::class, 'index']);

    Route::post('/v1/system-modules', [SystemController::class, 'modules']);

});