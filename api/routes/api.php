<?php

use App\Http\Controllers\Auth\{LoginController, RegisterController};
use Illuminate\Support\Facades\Route;


//Authenticate users routes group
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('users.logout');
    Route::apiResource('users', 'User\UserController');
});


// Not Authenticate user route group
Route::group(['middleware' => ['guest:api']], function () {
    Route::post('register', [RegisterController::class, 'register'])->name('users.register');
    Route::post('login', [LoginController::class, 'login'])->name('users.login');
});
