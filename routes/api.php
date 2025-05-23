<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    
    // Students
    Route::get('students', [StudentController::class, 'index']);
    Route::get('students/{id}', [StudentController::class, 'show']);
    Route::post('students', [StudentController::class, 'store']);
    Route::put('students/{id}', [StudentController::class, 'update']);
    Route::delete('students/{id}', [StudentController::class, 'destroy']);
    // Courses
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{id}', [CourseController::class, 'show']);
    Route::post('courses', [CourseController::class, 'store']);
    Route::put('courses/{id}', [CourseController::class, 'update']);
    Route::delete('courses/{id}', [CourseController::class, 'destroy']);
    // Enrollments
    Route::get('enrollments', [EnrollmentController::class, 'index']);
    Route::post('enrollments', [EnrollmentController::class, 'store']);
    Route::delete('enrollments/{id}', [EnrollmentController::class, 'destroy']);
});
