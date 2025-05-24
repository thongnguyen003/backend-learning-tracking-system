<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminUserController;


    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\StudentController;
    use App\Http\Controllers\CourseGoalController;
    use App\Http\Controllers\JournalController;
    use App\Http\Controllers\StudentProfileController;
    use App\Http\Controllers\MessageController;
    use App\Http\Controllers\CourseController;
    use App\Http\Controllers\DetailMessageController;
    use App\Http\Controllers\api\TeacherController;
    use App\Http\Controllers\JournalGoalController;
    use App\Http\Controllers\JournalTimeController;
    use App\Http\Controllers\AchievementController;
    use App\Http\Controllers\AchievementImageController;
    
    use App\Http\Controllers\ClassController;
use App\Http\Middleware\AuthMiddleware;

    use App\Http\Controllers\JournalClassesController;
    use App\Http\Controllers\JournalSelfController;
    
    // Route không yêu cầu xác thực
    // Comment out or remove this line temporarily to fix missing StudentProfileController error
    // Route::apiResource('students', StudentProfileController::class);
    Route::put('/student/change-password/{id}', [StudentController::class, 'changePassword']);
    Route::get('course-goals/getByCourseStudentId/{courseStudentId}', [CourseGoalController::class, 'indexByStudent']);
    Route::group(['prefix' => 'journal'], function () {
        Route::get('/getByCourseStudentId/{id}', [JournalController::class, 'getJournalsByCourseStudentId']);
    });
    
    Route::apiResource('course-goals', CourseGoalController::class);


    Route::post('/login', [AuthController::class, 'login'])->name('login');
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

    });


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


    Route::prefix('admin')->group(function () {
        // Get all users
        Route::get('users', [AdminUserController::class, 'index']);
        // Get only students
        Route::get('students', [AdminUserController::class, 'getStudents']);
        // Get only teachers
        Route::get('teachers', [AdminUserController::class, 'getTeachers']);
        // Get only admins
        Route::get('admins', [AdminUserController::class, 'getAdmins']);
        // Add multiple users
        Route::post('add-user', [AdminUserController::class, 'addUsers']);
        // Update a user
        Route::put('users/{id}', [AdminUserController::class, 'updateUser']);
        // Delete a user
        Route::delete('users/{id}', [AdminUserController::class, 'deleteUser']);
    });
    Route::group(['prefix'=>'achievement'],function(){
        Route::get('/getByStudentId/{id}',[AchievementController::class,'getByStudentId']);
        Route::post('/',[AchievementController::class,'store']);
        Route::put('/{id}', [AchievementController::class, 'update']);
        Route::delete('/{id}', [AchievementController::class, 'destroy']);
         Route::group(['prefix'=>'image'],function(){
            Route::post('/',[AchievementImageController::class,'store']);
            Route::put('/{id}', [AchievementImageController::class, 'update']);
            Route::delete('/{id}', [AchievementImageController::class, 'destroy']);
        });
    });

    Route::get('/admin/classes', [ClassController::class, 'index']);
    Route::post('/admin/create-classes', [ClassController::class, 'store']);
Route::get('/student/{id}', [StudentController::class, 'show']);
Route::put('/student/update-profile/{id}', [StudentController::class, 'updateProfile']);
