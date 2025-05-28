<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentRepository
{
    protected $model;

    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->select('id', 'student_name')->get();
    }

    public function findById($id)
    {
        return $this->model->with(['class', 'courses', 'achievements'])->findOrFail($id);
    }

    public function getStudentsByClassId($classId)
    {
        return $this->model->where('class_id', $classId)->select('id', 'student_name')->get();
    }

    public function updatePassword($id, $newPassword)
    {
        $student = $this->model->findOrFail($id);
        $student->password = Hash::make($newPassword);
        $student->save();
        return $student;
    }

    public function update($id, $data)
    {
        $student = $this->model->findOrFail($id);
        $student->update($data);
        return $student;
    }
}