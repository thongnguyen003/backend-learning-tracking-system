<?php
namespace App\Repositories;
use App\Models\Classes;
use Illuminate\Routing\ResponseFactory;
class ClassRepository extends Repository {
    public function __construct(Classes $model){
        $this->model = $model;
    }
    // retrive data of class and name of teacher and number of course flowing courses by teacher_id
    public function getClassDetailsByTeacherId( int $teacherId){
        $Classes = Classes::whereHas('teachers', function($query) use ($teacherId) {
        $query->where('teachers.id', $teacherId);
        })
        ->with('teachers:id,teacher_name') // tải sẵn thông tin giáo viên
        ->withCount('teachers')    // đếm số lượng giáo viên của mỗi lớp
        ->with(['class_teachers' => function($query2) {
            $query2->select('id', 'classes_id', 'teacher_id');
        }])
        ->get();
        if($Classes->isEmpty()){
            return response()->json(['message' => 'No class founds for the given teacher ID'], 404);
        }
        return response()->json($Classes);
    }
}
