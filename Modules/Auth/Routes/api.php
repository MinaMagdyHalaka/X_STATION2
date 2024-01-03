<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\ChangePasswordController;
use Modules\Auth\Http\Controllers\LoginController;
use Modules\Auth\Http\Controllers\LogoutController;
use Modules\Auth\Http\Controllers\ProfileController;
use Modules\Auth\Http\Controllers\RegisterController;
use Modules\Auth\Http\Controllers\ForgetPasswordController;
use Modules\Auth\Http\Controllers\VerifyEmailController;

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


Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);
});

Route::post('auth/logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'auth'], function () {
    Route::get('send_code', [VerifyEmailController::class, 'sendEmail']);
    Route::post('verify_email', [VerifyEmailController::class, 'verifyEmail']);
});

Route::group(['prefix' => 'auth/change_password', 'middleware' => ['auth:sanctum']], function () {
    Route::put('', [ChangePasswordController::class, 'changePassword']);
});

Route::group(['prefix' => 'auth'], function () {
    Route::get('send_code', [ForgetPasswordController::class, 'sendResetCode']);
    Route::post('reset_password', [ForgetPasswordController::class, 'resetPassword']);
});

Route::group(['prefix' => 'auth/profile', 'middleware' => ['auth:sanctum']], function () {
    Route::get('', [ProfileController::class, 'show']);
    Route::post('', [ProfileController::class, 'update']);
});

//pm.environment.set('AUTH_TOKEN',pm.response.json().data.token)
//pm.test("Status code is 200", function () {
//    pm.response.to.have.status(200);
//});
