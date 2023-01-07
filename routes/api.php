<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/register-user', [UserController::class, 'show']);
Route::get('/get-user/{id}', [UserController::class, 'find']);
Route::post('/register-user', [UserController::class, 'store']);
Route::put('/update-user/{id}', [UserController::class, 'update']);
Route::post('/login-user', [UserController::class, 'authenticate']);


