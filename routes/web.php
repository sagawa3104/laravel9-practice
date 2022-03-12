<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryItemController;
use App\Http\Controllers\CategorySpecificationController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProductSpecificationController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\RecordedInspectionController;
use App\Http\Controllers\RecordedProductController;
use App\Http\Controllers\SpecificationController;
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
Route::get('products/{product}/attach-phases', [InspectionController::class, 'attachPhases'])->name('products.attach-phases');
Route::put('products/{product}/attach-phases', [InspectionController::class, 'applyPhases'])->name('products.apply-phases');
Route::get('products/{product}/attach-specifications', [ProductSpecificationController::class, 'attachSpecifications'])->name('products.attach-specifications');
Route::put('products/{product}/attach-specifications', [ProductSpecificationController::class, 'applySpecifications'])->name('products.apply-specifications');
Route::get('products/{product}/attach-units', [ProductUnitController::class, 'attachUnits'])->name('products.attach-units');
Route::put('products/{product}/attach-units', [ProductUnitController::class, 'applyUnits'])->name('products.apply-units');
Route::resource('phases', PhaseController::class);
Route::get('categories/{category}/attach-items', [CategoryItemController::class, 'attachItems'])->name('categories.attach-items');
Route::put('categories/{category}/attach-items', [CategoryItemController::class, 'applyItems'])->name('categories.apply-items');
Route::get('categories/{category}/attach-specifications', [CategorySpecificationController::class, 'attachSpecifications'])->name('categories.attach-specifications');
Route::put('categories/{category}/attach-specifications', [CategorySpecificationController::class, 'applySpecifications'])->name('categories.apply-specifications');
Route::resource('units', UnitController::class);
Route::resource('categories', CategoryController::class);
Route::resource('items', ItemController::class);
Route::resource('specifications', SpecificationController::class);
Route::post('recorded-products/create-recorded-inspections-all', [RecordedProductController::class, 'createRecordedInsectionsAll'])->name('recorded-products.create-recorded-inspections-all');
Route::resource('recorded-products', RecordedProductController::class);
Route::resource('recorded-inspections', RecordedInspectionController::class);
