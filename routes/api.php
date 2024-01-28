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

Route::put('admin/travel' , [Admin\TravelController::class , 'store'])
            ->middleware(['auth:sanctum' , 'role:admin']);

Route::post('login' , Auth\LoginController::class);
