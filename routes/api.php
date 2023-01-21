<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FacilitesController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;

use App\Models\Transaction;
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


Route::get('/get-user/{id}', [UserController::class, 'find']);
Route::post('/register-user', [UserController::class, 'store']);
Route::post('/login-user', [UserController::class, 'login']);

//user
Route::middleware(['auth:sanctum', 'abilities:normal'])->group(function () { 
    Route::get('/show-kost', [KostController::class, 'show']);
    Route::post('/create-comment', [CommentsController::class, 'create']); 
    Route::get('/filter-comment-bypost/{id}', [CommentsController::class, 'filterByPost']);
    Route::put('/update-user/{id}', [UserController::class, 'update']);
    Route::get('/logout-user', [UserController::class, 'logout']);
    Route::post('/start-transaction', [TransactionsController::class, 'create']);
    Route::get('/get-transaction/{tranc_id}', [TransactionsController::class, 'getTransactionById']);
});

//owner
Route::middleware(['auth:sanctum', 'abilities:owner'])->group(function () { 
    Route::post('/create-kost', [KostController::class, 'create']);
    Route::post('/update-kost', [KostController::class, 'create']);
    
});

//testing
Route::post('/create-facilities', [FacilitesController::class, 'create']);
Route::post('/search-kost', [KostController::class, 'filterKostByFacilities']);








