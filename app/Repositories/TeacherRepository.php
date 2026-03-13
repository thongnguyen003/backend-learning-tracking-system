<?php
namespace App\Repositories;


use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;


class TeacherRepository extends Repository
{
    public function __construct(Teacher $model)
    {
        $this->model = $model;
    }

    public function login(array $teacherData)
    {
        $teacher = $this->model->where('email', $teacherData['email'])->first();
        if ($teacher && Hash::check($teacherData['password'], $teacher->password)) {
            return response()->json($teacher);
        } else {
            return response()->json(['error' => 'Unexisted Account'], 401);
        }
    }

    public function getTeacherById(int $id)
    {
        $teacher = $this->model->find($id);
        if ($teacher) {
            return response()->json($teacher);
        } else {
            return response()->json(['error' => 'Unexisted Account'], 401);
        }
    }

    public function updatePassword($id, $newPassword)
    {
        $teacher = $this->model->find($id);
        if ($teacher) {
            $teacher->password = Hash::make($newPassword);
            $teacher->save();
        }
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

    public function update($id, $data)
    {
        $teacher = $this->findById($id);
        if (!$teacher) {
            throw new \Exception("Teacher not found with ID: {$id}");
        }
        $teacher->update($data);
        return $teacher;
    }

}
?>
