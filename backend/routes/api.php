<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CertificateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Students
    Route::apiResource('students', StudentController::class);
    
    // Professors
    Route::apiResource('professors', ProfessorController::class);
    
    // Courses
    Route::apiResource('courses', CourseController::class);
    
    // Events
    Route::apiResource('events', EventController::class);
    
    // Certificates
    Route::apiResource('certificates', CertificateController::class);
});