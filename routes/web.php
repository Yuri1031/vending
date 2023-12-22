<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DetailController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//tip site
//https://qiita.com/greencha/items/54d3d149b5f3d49e0987    (編集画面について)
//https://pgmemo.tokyo/data/archives/1483.html　　（ログイン画面について）


//ログイン画面
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



//一覧画面
Route::get('/list', [App\Http\Controllers\ProductsController::class, 'index'])->name('list');
Route::get('/search', [App\Http\Controllers\ProductsController::class, 'searchIndex'])->name('search');


//新規登録
Route::get('/register/create', [App\Http\Controllers\ProductsController::class,'create'])->name('register.create');
Route::POST('/register/store', [App\Http\Controllers\ProductsController::class,'store'])->name('register.store');

//編集画面
Route::get('/list/{id}',[App\Http\Controllers\ProductsController::class,'edit'])->name('edit');
Route::POST('/list/{id}',[App\Http\Controllers\ProductsController::class,'update'])->name('update.list');

//削除
Route::delete('/list/{id}',[App\Http\Controllers\ProductsController::class,'destroy'])->name('destroy');


