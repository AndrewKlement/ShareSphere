<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

Route::middleware("auth")->group(function (){
    //logout
    Route::post('/logout', [AuthController::class, "logout"])->name("logout");
    
    Route::view('/', 'index')->name("home");
});

// login
Route::get('/login', [AuthController::class, "login"])->name("login");
Route::post('/login', [AuthController::class, "loginPost"])->name("login.post");


//register
Route::get('/register', [AuthController::class, "register"])->name("register");
Route::post('/register', [AuthController::class, "registerPost"])->name("register.post");


