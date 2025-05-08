<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::group(['prefix'=>'course'],function(){
    Route::get('/getByStudentId/{id}',[CourseController::class,'getCourseByStudentId']);
});
use App\Http\Middleware\AuthMiddleware;
Route::post('/login', [AuthController::class, 'login'])->middleware(AuthMiddleware::class);
Route::get('course-goals/{courseStudentId}', [CourseGoalController::class, 'indexByStudent']);
