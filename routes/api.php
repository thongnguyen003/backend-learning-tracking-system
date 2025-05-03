<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::group(['prefix'=>'course'],function(){
    Route::get('/getByStudentId/{id}',[CourseController::class,'getCourseByStudentId']);
});
