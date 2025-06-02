<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseGoalController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DetailMessageController;
use App\Http\Controllers\api\TeacherController;
use App\Http\Controllers\JournalGoalController;
use App\Http\Controllers\JournalTimeController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AchievementImageController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\JournalClassesController;
use App\Http\Controllers\JournalSelfController;
use App\Http\Controllers\CourseStudentController;
use App\Http\Controllers\ClassTeacherController;
use App\Http\Controllers\StudentVisitController;
// use App\Http\Controllers\ClassController;
// Route không yêu cầu xác thực
Route::put('/student/change-password/{id}', [StudentController::class, 'changePassword']);
Route::get('course-goals/getByCourseStudentId/{courseStudentId}', [CourseGoalController::class, 'indexByStudent']);
Route::group(['prefix' => 'journal'], function () {
    Route::get('/getByCourseStudentId/{id}', [JournalController::class, 'getJournalsByCourseStudentId']);
    Route::post('/',[JournalController::class, 'store']);
});
Route::apiResource('course-goals', CourseGoalController::class);

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix'=>'message'],function(){
    Route::get('/getByJournalGoal/{id}',[MessageController::class,'getMessageDetailByJournalGoalId']);
    Route::get('/getByJournalClass/{id}',[MessageController::class,'getMessageDetailByJournalClassId']);
    Route::get('/getByJournalSelf/{id}',[MessageController::class,'getMessageDetailByJournalSelfId']);
    Route::group(['prefix'=>'detail'],function(){
        Route::post('/',[DetailMessageController::class,'store']);
        Route::delete('/{id}',[DetailMessageController::class,'destroy']);
        Route::put('/{id}',[DetailMessageController::class,'update']);
    });
    Route::post('/',[MessageController::class,'store']);
    Route::get('/getByCourseGoal/{id}',[MessageController::class,'getMessageDetailByCourseGoalId']);
});
Route::group(['prefix'=>'course'],function(){
    Route::get('/getByStudentId/{id}',[CourseController::class,'getCourseByStudentId']);
    Route::get('/getByClassId/{id}',[CourseController::class,'getCourseByClassId']);
    Route::get('/getByCourseId/{id}',[CourseController::class,'getCourseByCourseId']);
    Route::post('/',[CourseController::class,'store']);
    Route::put('/{id}',[CourseController::class,'update']);
});
Route::group(['prefix'=>'course-student'],function(){
    Route::post('/',[CourseStudentController::class,'store']);
});
Route::group(['prefix'=>'journal-times'],function(){
    Route::put('/{id}',[JournalTimeController::class,'update']);
});
Route::get('subjects', [SubjectController::class, 'index']);
Route::get('subjects/{id}', [SubjectController::class, 'show']);
Route::post('subjects', [SubjectController::class, 'store']);
Route::put('subjects/{id}', [SubjectController::class, 'update']);
Route::delete('subjects/{id}', [SubjectController::class, 'destroy']);

Route::apiResource('journal-times', JournalTimeController::class);
Route::get('journal-times/course/{courseId}', [JournalTimeController::class, 'getJournalTimesByCourseId']);
Route::get('/teachers', [TeacherController::class, 'index']);
Route::get('/student/{id}', [StudentController::class, 'show']);
Route::put('/student/update-profile/{id}', [StudentController::class, 'updateProfile']);
Route::get('/journal-goals', [JournalGoalController::class, 'index']);
Route::get('/journal-goals/{id}', [JournalGoalController::class, 'show']);
Route::post('/journal-goals', [JournalGoalController::class, 'store']);
Route::put('/journal-goals/{id}', [JournalGoalController::class, 'update']);
Route::delete('/journal-goals/{id}', [JournalGoalController::class, 'destroy']);
Route::get('/students/class/{classId}', [StudentController::class, 'showStudentsByClassId']);
Route::get('/teachers/class/{classId}', [TeacherController::class, 'showByClassId']);

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::get('classes', [ClassController::class, 'index']);
    Route::post('create-classes', [ClassController::class, 'store']);
    Route::get('users', [AdminUserController::class, 'index']);
    Route::get('students', [AdminUserController::class, 'getStudents']);
    Route::get('teachers', [AdminUserController::class, 'getTeachers']);
    Route::get('admins', [AdminUserController::class, 'getAdmins']);
    Route::post('add-user', [AdminUserController::class, 'addUsers']);
    Route::put('users/{id}', [AdminUserController::class, 'updateUser']);
    Route::delete('users/{id}', [AdminUserController::class, 'deleteUser']);
    Route::get('achievements', [AchievementController::class, 'index']);
});

Route::get('/students/byCourseId/{id}', [StudentController::class, 'showStudentsByCourseId']);

Route::group(['prefix' => 'achievement'], function () {
    Route::get('/getByStudentId/{id}', [AchievementController::class, 'getByStudentId']);
    Route::post('/', [AchievementController::class, 'store']);
    Route::put('/{id}', [AchievementController::class, 'update']);
    Route::delete('/{id}', [AchievementController::class, 'destroy']);
    Route::group(['prefix' => 'image'], function () {
        Route::post('/', [AchievementImageController::class, 'store']);
        Route::put('/{id}', [AchievementImageController::class, 'update']);
        Route::delete('/{id}', [AchievementImageController::class, 'destroy']);
    });
});

Route::get('/admin/classes', [ClassController::class, 'index']);
Route::post('/admin/create-classes', [ClassController::class, 'store']);
Route::get('/student/{id}', [StudentController::class, 'show']);
Route::put('/student/update-profile/{id}', [StudentController::class, 'updateProfile']);
Route::get('/students/class/{classId}', [StudentController::class, 'showStudentsByClassId']);


Route::group(['prefix' => 'class'], function () {
    Route::get('/getByTeacherId/{id}', [ClassController::class, 'getClassByTeacherId']);
    Route::get('/getByClassId/{id}', [ClassController::class, 'getClassByClassId']);
});

// admin: class_teacher
Route::prefix('class-teachers')->group(function () {
    Route::get('/', [ClassTeacherController::class, 'index']);
    Route::get('/{id}', [ClassTeacherController::class, 'show']);
    Route::post('/', [ClassTeacherController::class, 'store']);
    Route::put('/{id}', [ClassTeacherController::class, 'update']);
    Route::delete('/', [ClassTeacherController::class, 'destroy']);
    Route::get('/{id}', [ClassTeacherController::class, 'showTeachersByClassId']);
});
Route::get('/class-teachers/class/{classId}/teachers', [ClassTeacherController::class, 'showTeachersByClassId']);
Route::prefix('journal/journal-classes')->group(function () {
    Route::get('/', [JournalClassesController::class, 'index']);
    Route::get('/{id}', [JournalClassesController::class, 'show']);
    Route::post('/', [JournalClassesController::class, 'store']);
    Route::put('/{id}', [JournalClassesController::class, 'update']);
    Route::delete('/{id}', [JournalClassesController::class, 'destroy']);
});

Route::prefix('journal/journal-selfs')->group(function () {
    Route::get('/', [JournalSelfController::class, 'index']);
    Route::get('/{id}', [JournalSelfController::class, 'show']);
    Route::post('/', [JournalSelfController::class, 'store']);
    Route::put('/{id}', [JournalSelfController::class, 'update']);
    Route::delete('/{id}', [JournalSelfController::class, 'destroy']);
});

Route::get('teachers/{teacherId}/classes', [ClassTeacherController::class, 'showClassesByTeacherId']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/track-visit', [StudentVisitController::class, 'trackVisit']);
    Route::get('/student-visits/{studentId}', [StudentVisitController::class, 'getVisitDates']);
    Route::get('/student-visits-by-class', [StudentVisitController::class, 'getVisitCountsByClass']);
});
