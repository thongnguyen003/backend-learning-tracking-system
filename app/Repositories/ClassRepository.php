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
}