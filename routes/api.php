<?php

use App\Http\Controllers\Api\PhaseController;
use App\Http\Controllers\Api\RecordedInspectionController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('phases', [PhaseController::class, 'index']);
Route::get('recorded-inspections', [RecordedInspectionController::class, 'index']);
Route::get('recorded-inspections/{recorded_inspection}', [RecordedInspectionController::class, 'show']);
