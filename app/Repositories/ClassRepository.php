<?php

namespace App\Repositories;

use App\Models\Classes;

class ClassRepository
{
    protected $model;

    public function __construct(Classes $model)
    {
        $this->model = $model;
    }
    

     public function getAllClasses()
    {
        return Classes::all(); 
    }
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // retrive data of class and name of teacher and number of course flowing courses by teacher_id

     public function getClassDetailsByTeacherId( int $teacherId){
        $classes = Classes::whereHas('class_teachers', function($query) use ($teacherId) {
        $query->where('teacher_id', $teacherId);
        })
        // ->with('teachers:id,teacher_name') tải sẵn thông tin giáo viên
        ->withCount('students')   //  đếm số lượng học sinh của mỗi lớp
        ->withCount('class_teachers')
        // ->with(['class_teachers' => function($query2) {
        //     $query2->select('id', 'classes_id', 'teacher_id');
        // }])
        ->get();
        return response()->json($classes);
    }
    public function getClassById(int $id)
    {
        $class = $this->model
            ->where('id', $id)
            ->select('id', 'name', 'start_day')
            ->withCount('students') 
            ->first();

        return $class;
    }
    public function findById(int $id)
    {
        // Lấy lớp cùng số học sinh (count students), tên lớp và ngày bắt đầu
        return $this->model
            ->withCount('students') // đếm số học sinh
            ->find($id, ['id', 'name', 'start_day']); // lấy các cột cần thiết
    }
    public function findStudents ($class_id){
        $result = $this->model::where('id',$class_id)
        ->with(['students'])
        ->get();
        if($result && count($result)>0){
            return $result[0]->students;
        }
        return false;
    }
}