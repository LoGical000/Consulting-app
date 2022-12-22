<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





//public routes

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/expert_register',[AuthController::class,'ExpertRegister']);


//protected routes


Route::group(['middleware' => ['auth:sanctm']],function(){

    Route::post('/logout',[AuthController::class,'logout']);

});