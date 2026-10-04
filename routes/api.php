<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\AppointmentController;
use App\Http\Controllers\Dashboard\ClinicController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\DoctorScheduleController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\ReviewController;
use App\Http\Controllers\Dashboard\SpecializationController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;









Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login',[AuthController::class,'login'])->middleware('throttle:login');
Route::post('register',[AuthController::class,'register']);
Route::middleware('auth:sanctum')->post('logout',[AuthController::class,'logout']);
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

Route::middleware('auth:sanctum')
    ->prefix('Dashboard')
    ->group(function () {
        Route::apiResource('users',UserController::class)->middleware(['role:admin,patient','throttle:2,1']);

        Route::apiResource('doctors',DoctorController::class)->middleware('role:admin,doctor');

        Route::apiResource('clinics',ClinicController::class)->middleware('role:admin');

        Route::apiResource('specializations',SpecializationController::class)->middleware('role:admin');

        Route::apiResource('doctor_schedules',DoctorScheduleController::class)->middleware('role:doctor');

        Route::apiResource('reviews',ReviewController::class)->middleware('role:patient');

        Route::apiResource('appointments',AppointmentController::class)->middleware('role:patient,admin');
        Route::patch('appointments/{appointment}/confirm',[AppointmentController::class,'confirm'])->middleware('role:admin,doctor');
        Route::patch('appointments/{appointment}/complete',[AppointmentController::class,'complete'])->middleware('role:admin,doctor');
        Route::patch('appointments/{appointment}/cancel',[AppointmentController::class,'cancel'])->middleware('role:patient,doctor');
        Route::get('notifications',[NotificationController::class,'index']);
        Route::get('notifications/unread',[NotificationController::class,'unread']);
        Route::patch('notifications/{notification}/read',[NotificationController::class,'markAsRead']);
        Route::get('notifications/unread-count',[NotificationController::class,'unReadCount']);
    });


Route::post('/test-request', [UserController::class, 'testRequest']);