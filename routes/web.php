<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ShippingDetailController;

// login
Route::get('/login', [AuthController::class, "login"])->name("login");
Route::post('/login', [AuthController::class, "loginPost"])->name("login.post");

//register
Route::get('/register', [AuthController::class, "register"])->name("register");
Route::post('/register', [AuthController::class, "registerPost"])->name("register.post");

Route::middleware("auth")->group(function (){  
    //home
    Route::get('/', [IndexController::class, "index"])->name("home");
    Route::get('/search', [IndexController::class, "indexSearch"])->name('homeSearch');

    
    //logout
    Route::post('/logout', [AuthController::class, "logout"])->name("logout");
    
    //cart
    Route::get('/cart', [CartController::class, "viewCart"])->name("cart");
    Route::post('/cart/purchase', [CartController::class, 'processPurchase'])->name('cart.processPurchase');
    Route::post('/cart/payment', [CartController::class, 'processPayment'])->name('cart.processPayment');
    Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

    //transaction
    Route::get('/transaction', [TransactionController::class, 'viewTransaction'])->name('transaction');

    //shipping-detail
    Route::get('/shipping-detail', [ShippingDetailController::class, "shippingDetail"])->name("shippingDetail");
    Route::post('/shipping-detail', [ShippingDetailController::class, "shippingDetailPost"])->name("shippingDetail.post");

    //view-product
    Route::get('/view/{id}', [ItemController::class, "viewProduct"])->name("viewProduct");
    Route::post('/product/cart', [CartController::class, 'viewProductPostCart'])->name('viewProduct.cart');
    Route::post('/product/buy', [CartController::class, 'viewProductPostBuy'])->name('viewProduct.buy');

    //add-product
    Route::get('/add-product', [ItemController::class, "addProduct"])->name("addProduct");
    Route::post('/add-product', [ItemController::class, "addProductPost"])->name("addProduct.post");

    //manage-product
    Route::get('/manage-product', [ItemController::class, "manageProduct"])->name("manageProduct");
    Route::delete('/manage-product/{id}', [ItemController::class, "manageProductDelete"])->name("manageProduct.delete");
    
    //edit-product
    Route::get('/edit-product/{id}', [ItemController::class, "editProduct"])->name("editProduct");
    Route::patch('/edit-product/{id}', [ItemController::class, "editProductPatch"])->name("editProduct.patch");

    //return
    Route::get('/return', [ReturnController::class, "viewReturn"])->name("return");
    Route::get('/return-request', [ReturnController::class, "viewReturnRequest"])->name("returnRequest");
    Route::post('/return-request/{id}/confirm', [ReturnController::class, "confirmReturnRequest"])->name("returnRequest.confirm");
    Route::get('/return-due', [ReturnController::class, "viewDue"])->name("returnDue");
    Route::post('/return-due/request', [ReturnController::class, "requestReturn"])->name("return.request");
    Route::post('/return-due/process', [ReturnController::class, "processReturn"])->name("return.process");
});



