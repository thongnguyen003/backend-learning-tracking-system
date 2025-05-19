<?php
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
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
    
use App\Http\Middleware\AuthMiddleware;

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
    });

Route::get('/student/{id}', [StudentController::class, 'show']);
Route::put('/student/update-profile/{id}', [StudentController::class, 'updateProfile']);
Route::get('/journal-goals', [JournalGoalController::class, 'index']);
Route::get('/journal-goals/{id}', [JournalGoalController::class, 'show']);
Route::post('/journal-goals', [JournalGoalController::class, 'store']);
Route::put('/journal-goals/{id}', [JournalGoalController::class, 'update']);
Route::delete('/journal-goals/{id}', [JournalGoalController::class, 'destroy']);

