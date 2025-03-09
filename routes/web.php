<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\IndexController;


Route::middleware("auth")->group(function (){
    //home
    Route::get('/', [IndexController::class, "index"])->name("home");
    
    //logout
    Route::post('/logout', [AuthController::class, "logout"])->name("logout");

    //cart
    Route::view('/cart', 'cart')->name("cart");

    //add-product
    Route::get('/add-product', [ItemController::class, "addProduct"])->name("addProduct");
    Route::post('/add-product', [ItemController::class, "addProductPost"])->name("addProduct.post");

    //manage-product
    Route::get('/manage-product', [ItemController::class, "manageProduct"])->name("manageProduct");
    Route::post('/manage-product', [ItemController::class, "manageProductPost"])->name("manageProduct.post");
    Route::delete('/manage-product/{id}', [ItemController::class, "manageProductDelete"])->name("manageProduct.delete");

    //return
    Route::view('/return', 'return')->name("return");

    //transaction
    Route::view('/transaction', 'transaction')->name("transaction");
});

// login
Route::get('/login', [AuthController::class, "login"])->name("login");
Route::post('/login', [AuthController::class, "loginPost"])->name("login.post");


//register
Route::get('/register', [AuthController::class, "register"])->name("register");
Route::post('/register', [AuthController::class, "registerPost"])->name("register.post");


