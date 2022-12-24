<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\Available_timeController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





//public routes

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/expert_register',[AuthController::class,'ExpertRegister']);


Route::post('/create_category',[CategoryController::class,'createCategory']);


Route::get('get_experts/{category_id}',[ExpertController::class,'getexperts']);
Route::get('get_users/{user_id}',[ExpertController::class,'getuser']);
Route::get('get_expert_datails/{expert_id}',[ExpertController::class,'getExpertDetails']);
Route::get('get_all_experts',[ExpertController::class,'getAllExperts']);

Route::get('get_available_times/{user_id}',[Available_timeController::class,'getAvailableTimes']);

Route::post('/make_appointment',[AppointmentController::class,'makeAppointment']);

Route::get('get_appointment/{expert_id}',[AppointmentController::class,'getAppointment']);
Route::get('get_username/{user_id}',[ExpertController::class,'getusername']);




//protected routes


Route::group(['middleware' => ['auth:sanctm']],function(){

    Route::post('/logout',[AuthController::class,'logout']);

});