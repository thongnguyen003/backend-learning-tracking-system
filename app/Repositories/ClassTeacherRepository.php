<?php

namespace App\Repositories;

use App\Models\ClassTeacher;

class ClassTeacherRepository
{
    protected $model;

    public function __construct(ClassTeacher $classTeacher)
    {
        $this->model = $classTeacher;
    }

    public function all()
    {
        return $this->model::with(['teacher', 'class'])->get();
    }

    public function find($id)
    {
        return $this->model::with(['teacher', 'class'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function update($id, array $data)
    {
        $classTeacher = $this->find($id);
        $classTeacher->update($data);
        return $classTeacher;
    }

    public function delete($id)
    {
        $classTeacher = $this->find($id);
        $classTeacher->delete();
        return $classTeacher;
    }
    public function findTeachersByClassId($classId)
    {
        return $this->model::where('class_id', $classId)
            ->join('teachers', 'class_teachers.teacher_id', '=', 'teachers.id')
            ->select('teachers.*') // Select fields from the teachers table
            ->get();
    }
}