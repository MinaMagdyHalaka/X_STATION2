<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

Route::group(['prefix' => 'users', 'middleware' => [GeneralHelper::authMiddleware()]], function (){
//    Route::get('', [UserController::class, 'index']);
//    Route::post('', [UserController::class, 'store']);
//    Route::get('{id}', [UserController::class, 'show']);
//    Route::post('{id}', [UserController::class, 'update']);
    Route::delete('{id}', [UserController::class, 'destroy']);
    Route::post('rate', [UserController::class,'rating']);
    Route::get('{userId}/favorite', [UserController::class,'favorites']);
    Route::get('all_favorites', [UserController::class,'showAllFavorites']);
});
