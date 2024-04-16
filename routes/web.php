<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellingController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('isLogin')->group(function(){
    
    Route::get('/', function () {
        return view('index');
    });

    //product 
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product/create', [ProductController::class, 'create']);
    Route::post('/product/post', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit']);
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::post('/product/delete/{id}', [ProductController::class, 'destroy']);

    //selling

    Route::get('/selling', [SellingController::class, 'index']);
    Route::get('/selling/create', [SellingController::class, 'create']);
    Route::post('/selling/post', [SellingController::class, 'store']);
    Route::get('/selling/detail/{id}', [SellingController::class, 'show']);
    Route::get('/selling/download/{id}', [SellingController::class, 'download']);
});

Route::middleware('isGuest')->group(function(){

    Route::get('/login', [UserController::class, 'login']);
    Route::post('/login/post', [UserController::class, 'loginInput'])->name('login.post');

});
