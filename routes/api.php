<?php

use App\Http\Controllers\SelectMenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('refresh', function () {
    Artisan::call('migrate:fresh');
});

Route::get('refresh_db', function () {
    $process = Process::run('composer install');

    return $process->successful();
});

Route::group(['prefix' => 'select_menu'], function (){
    Route::get('categories', [SelectMenuController::class, 'categories']);
});
