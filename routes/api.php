<?php

use App\Http\Controllers\Admin ;
use App\Http\Controllers\Auth;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('travels' , [TravelController::class , 'index']);
Route::get('travels/{travel:slug}/tours' , [TourController::class , 'index']);


Route::middleware(['auth:sanctum'])->group(function(){

    Route::middleware(['role:admin'])->group(function(){
        Route::post('admin/travel' , [Admin\TravelController::class , 'store']);
    })->prefix('admin');

    Route::middleware(['role:editor'])->group(function(){

    });

    Route::put('/travel' , [Admin\TravelController::class , 'update']);

});

Route::post('login' , Auth\LoginController::class);
