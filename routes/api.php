<?php

use App\Http\Controllers\AuthController;
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

Route::post('register',[AuthController::class, 'RegisterUser'])->name('register.api');
Route::post('login', [AuthController::class, 'LoginUser'])->name('login.api');

Route::middleware('auth:api')->group(function () {
    Route::get('user', [AuthController::class, 'AuthenticatedUser'])->name('user.api');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout.api');
});
