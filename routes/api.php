<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Api\StudentProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseGoalController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\JournalGoalController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::group(['prefix'=>'course'],function(){
    Route::get('/getByStudentId/{id}',[CourseController::class,'getCourseByStudentId']);
});
Route::apiResource('students', StudentProfileController::class);

// Route::middleware('auth:api')->post('/student/change-password', [StudentController::class, 'changePassword']);
Route::put('/student/change-password/{id}', [StudentController::class, 'changePassword']);
Route::post('/login', [AuthController::class, 'login'])->middleware(AuthMiddleware::class);
Route::get('course-goals/{courseStudentId}', [CourseGoalController::class, 'indexByStudent']);
Route::group(['prefix'=>'journal'],function(){
    Route::get('/getByCourseStudentId/{id}',[JournalController::class,'getJournalsByCourseStudentId']);
});

Route::get('/journal-goals', [JournalGoalController::class, 'index']);
Route::get('/journal-goals/{id}', [JournalGoalController::class, 'show']);
Route::post('/journal-goals', [JournalGoalController::class, 'store']);
Route::put('/journal-goals/{id}', [JournalGoalController::class, 'update']);
Route::delete('/journal-goals/{id}', [JournalGoalController::class, 'destroy']);

