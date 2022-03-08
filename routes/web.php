<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

Route::resource('products', ProductController::class);
Route::resource('phases', PhaseController::class);
Route::resource('units', UnitController::class);
Route::resource('categories', CategoryController::class);
Route::resource('items', ItemController::class);
