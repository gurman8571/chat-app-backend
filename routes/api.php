<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
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
Route::post('Register',[AuthController::class,'Register'])->name('register');
Route::post('login',[AuthController::class,'login'])->name('login');

Route::group(['middleware'=>['auth:sanctum']], function () {

    Route::post('logout',[AuthController::class,'logout'])->name('logout');


});
Route::get('/chats',[ChatController::class,'Index'])->name('getchats');
