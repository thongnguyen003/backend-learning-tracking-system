<?php
namespace App\Repositories;

use App\Models\Teacher;

class TeacherRepository extends Repository
{
    public function __construct(Teacher $model)
    {
        $this->model = $model;
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function findByClassId(int $classId)
    {
        return $this->model::join('class_teachers', 'teachers.id', '=', 'class_teachers.teacher_id')
            ->where('class_teachers.class_id', $classId)
            ->select('teachers.*') // Select the fields you want from the teachers table
            ->get();
    }
}
?>
