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
use App\Http\Controllers\JournalClassesController;
use App\Http\Controllers\JournalSelfController;
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

Route::prefix('journal-classes')->group(function () {
    Route::get('/', [JournalClassesController::class, 'index']);      
    Route::get('/{id}', [JournalClassesController::class, 'show']);  
    Route::post('/', [JournalClassesController::class, 'store']);    
    Route::put('/{id}', [JournalClassesController::class, 'update']);
    Route::delete('/{id}', [JournalClassesController::class, 'destroy']);
});
Route::prefix('journal-selfs')->group(function () {
    Route::get('/', [JournalSelfController::class, 'index']);
    Route::get('/{id}', [JournalSelfController::class, 'show']);
    Route::post('/', [JournalSelfController::class, 'store']);
    Route::put('/{id}', [JournalSelfController::class, 'update']);
    Route::delete('/{id}', [JournalSelfController::class, 'destroy']);
});