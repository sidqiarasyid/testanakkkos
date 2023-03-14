<?php

use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\DetailKostController;
use App\Http\Controllers\FacilitesController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\KAFController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\KostRulesController;
use App\Http\Controllers\KruController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RoomRulesController;
use App\Http\Controllers\RruController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;

use App\Models\Kost;
use App\Models\KostChat;
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


//no auth
Route::get('/get-user/{id}', [UserController::class, 'find']);
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/reg-google', [UserController::class, 'registerGoogle']);
Route::post('/log-google', [UserController::class, 'loginGoogle']);
Route::post('/login-admin', [UserController::class, 'loginAdmin']);
Route::get('/get-kost-details/{id}', [KostController::class, 'getDetail']);
Route::get('/show-facilities', [FacilitesController::class, 'show']);
Route::get('/show-facilitiesByKost/{kost_id}', [KAFController::class, 'showByKost']);
Route::get('/get-kost-bylocation/{location}', [KostController::class, 'findNearestKost']);
Route::get('/get-kost-bypopular/{location}', [KostController::class, 'findPopularKost']);
Route::post('/search-kost', [KostController::class, 'filterKostByFacilities']);
Route::get('/filter-comment-bypost/{id}', [CommentsController::class, 'filterByPost']);
Route::get('/get-image/{kostId}', [ImageController::class, 'getImageByKost']);
Route::get('symlink', function(){
    echo($_SERVER['DOCUMENT_ROOT']);
      $target =  $_SERVER['DOCUMENT_ROOT'] . "/project_laravel/testanakkkos/storage";
      $link =  $_SERVER['DOCUMENT_ROOT'] . "/storage";
      (symlink($target, $link)) ? response("success", 200) : response("gagal", 404);
});



//user
Route::middleware(['auth:sanctum', 'abilities:normal'])->group(function () { 
    Route::post('/create-comment', [CommentsController::class, 'create']); 
    Route::post('/start-transaction', [TransactionsController::class, 'create']);
    Route::get('/get-history/{userId}', [TransactionsController::class, 'getByUser']);
});

//all token
Route::middleware(['auth:sanctum'])->group(function () { 
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/create-chatroom', [ChatRoomController::class, 'create']);
    Route::post('/create-message', [MessageController::class, 'create']);
    Route::post('/update-user/{id}', [UserController::class, 'update']);
    Route::get('/get-chat-by-user/{userId}', [ChatRoomController::class, 'getRoomChatforUser']);
    Route::get('/get-chat-by-seller/{sellerId}', [ChatRoomController::class, 'getRoomChatforSeller']);
    Route::get('/get-message/{chatId}', [ChatRoomController::class, 'getMessage']);
});

//owner
Route::middleware(['auth:sanctum', 'abilities:owner'])->group(function () { 
    Route::post('/create-kost', [KostController::class, 'create']);
    Route::post('/create-cover', [ImageController::class, 'createCover']);
    Route::post('/create-detail-kost', [DetailKostController::class, 'create']);
    Route::get('/get-kost-byseller/{userId}', [DetailKostController::class, 'getKostBySeller']);
    Route::put('/update-kost', [KostController::class, 'update']);
    Route::post('/create-images', [ImageController::class, 'create']);
    Route::delete('/delete-kost/{id}', [KostController::class, 'delete']);
    Route::post('/create-facilities', [FacilitesController::class, 'create']);
    Route::post('/create-kostfacilities', [KAFController::class, 'create']);
});

//admin
Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () { 
    Route::put('/kost-accepted/{id}', [KostController::class, 'updateStatusAcc']);
    Route::post('/kost-rejected', [KostController::class, 'updateStatusRej']);
    Route::get('/get-all-kost', [KostController::class, 'show']);
    Route::get('/get-kost-admin', [KostController::class, 'getDetailAcc']);
    Route::get('/get-kost-pending', [KostController::class, 'getPending']);
});

//testing
Route::post('/add-cover/{kostId}', [KostController::class, 'addCoverImage']);
Route::get('/update-avg-rating/{kostId}', [RatingController::class, 'updateRating']);
Route::post('/create-room-rules', [RruController::class, 'create']);
Route::post('/create-kost-rules', [KruController::class, 'create']);
Route::get('/get-room-rules/{kostId}', [RruController::class, 'getRules']);
Route::get('/get-kost-rules/{kostId}', [KruController::class, 'getRules']);
Route::get('/trans', [TransactionsController::class, 'nyoba']);
Route::post('payment-callback', [TransactionsController::class, 'callbackHandler']);
Route::get('/get-chart/{id}', [TransactionsController::class, 'updateChart']);


