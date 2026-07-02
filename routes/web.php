<?php


use App\Http\Controllers\Dashboard\AppointmentController;
use App\Http\Controllers\Dashboard\ClinicController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\DoctorScheduleController;
use App\Http\Controllers\Dashboard\ReviewController;
use App\Http\Controllers\Dashboard\SpecializationController;
use App\Http\Controllers\Dashboard\UserController;
use App\Models\Specialization;
use Illuminate\Support\Facades\Route;















Route::get('/', function () {
    return view('welcome');
});

Route::prefix('Dashboard')
    ->name('Dashboard.')
    ->group(function () {
        Route::resource('users',UserController::class);

        Route::resource('doctors',DoctorController::class);

        Route::resource('clinics',ClinicController::class);

        Route::resource('specializations',SpecializationController::class);

        Route::resource('doctor_schedules',DoctorScheduleController::class);

        Route::resource('appointments',AppointmentController::class);

        Route::resource('reviews',ReviewController::class);
    });





