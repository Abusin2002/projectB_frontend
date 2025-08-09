<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\Api\UserLeadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// User Routes Start ------------------------>
Route::post('/contact',[UserLeadController::class,'store']);

// User Routes End ------------------------>



// Admin Routes Start ------------------------>
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::prefix('admin')->middleware('auth:api')->group(function(){

Route::post('/logout',[AuthController::class,'logout']);

Route::get('/getleads',[UserLeadController::class,'index']);
Route::delete('/deletelead/{id}',action: [UserLeadController::class,'destroy']);

});
// Admin Routes End ------------------------>