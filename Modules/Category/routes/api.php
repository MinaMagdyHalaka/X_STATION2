<?php

use App\Helpers\GeneralHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Category\app\Http\Controllers\CategoryController;
use Modules\Technical\app\Http\Controllers\TechnicalController;

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

Route::group(['prefix' => 'categories', 'middleware' => [GeneralHelper::authMiddleware()]], function (){
    Route::get('', [CategoryController::class, 'index']);
    Route::post('', [CategoryController::class, 'store']);
    Route::get('{id}', [CategoryController::class, 'show']);
    Route::post('{id}', [CategoryController::class, 'update']);
    Route::delete('{id}', [CategoryController::class, 'destroy']);
    Route::get('{categoryId}/technicals', [TechnicalController::class, 'getCategoryTechnicals']);
});
