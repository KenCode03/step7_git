<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




//一覧ページ
route::get('/product/',[ProductController::class,'index'])->name('product.index');

//新規作成ページ
route::get('/product/new',[ProductController::class,'new'])->name('product.new')->middleware('auth');

//新規追加処理
route::post('/product/create',[ProductController::class,'create'])->name('product.create')->middleware('auth');

//詳細ページ
route::get('/product/show/{id}',[ProductController::class,'show'])->name('product.show');

//編集ページ
route::get('/product/edit/{id}',[ProductController::class,'edit'])->name('product.edit')->middleware('auth');

//既存データ編集処理
Route::post('/product/update', [ProductController::class, 'update'])->name('product.update')->middleware('auth');

//削除処理
route::post('/product/delate', [ProductController::class,'delete'])->name('product.delete')->middleware('auth');

//ファイル取得
route::get('/product/getfile/{id}',[ProductController::class,'getfile'])->name('product.getfile')->middleware('auth');