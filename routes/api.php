<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\AppointmentController;
use App\Http\Controllers\Dashboard\ClinicController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\DoctorScheduleController;
use App\Http\Controllers\Dashboard\ReviewController;
use App\Http\Controllers\Dashboard\SpecializationController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;








Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);
Route::middleware('auth:sanctum')->post('logout',[AuthController::class,'logout']);
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

Route::middleware('auth:sanctum')
    ->prefix('Dashboard')
    ->group(function () {
        Route::apiResource('users',UserController::class)->middleware('role:admin,patient');

        Route::apiResource('doctors',DoctorController::class)->middleware('role:admin');

        Route::apiResource('clinics',ClinicController::class)->middleware('role:admin');

        Route::apiResource('specializations',SpecializationController::class)->middleware('role:admin');

        Route::apiResource('doctor_schedules',DoctorScheduleController::class)->middleware('role:doctor');

        Route::apiResource('appointments',AppointmentController::class)->middleware('role:patient');

        Route::apiResource('reviews',ReviewController::class)->middleware('role:patient');
    });


Route::post('/test-request', [UserController::class, 'testRequest']);