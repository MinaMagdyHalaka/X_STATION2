<?php

use App\Helpers\GeneralHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::group(['prefix' => 'technicals', 'middleware' => [GeneralHelper::authMiddleware()]], function (){
    Route::get('', [TechnicalController::class, 'index']);
    Route::post('', [TechnicalController::class, 'store'])->withoutMiddleware('auth:sanctum');
    Route::get('post/{postId}/apply', [TechnicalController::class, 'applyForPost'])
        ->Middleware('CheckTechnicalType');
    Route::post('update_applicant_status',[TechnicalController::class,'updateApplicantStatus'])->Middleware('CheckCustomerType');
    Route::get('all_accepted', [TechnicalController::class, 'allAccepted']);

});

Route::get('notifications',[TechnicalController::class,'getUserNotifications'])->middleware('auth:sanctum');
