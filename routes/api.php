<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::group(['prefix'=>'course'],function(){
    Route::get('/getByStudentId/{id}',[CourseController::class,'getCourseByStudentId']);
});

Route::put('/student/change-password/{id}', [StudentController::class, 'changePassword']);

Route::get('/student/{id}', [StudentController::class, 'show']);
Route::put('/student/update-profile/{id}', [StudentController::class, 'updateProfile']);
