<?php

namespace App\Repositories;

use App\Models\Student;
use App\Models\JournalTime;
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
    public function getStudentsByCourseId(int $courseId)
    {
        $students = $this->model->select('id', 'student_name')
        ->whereHas('courses',function($query) use ($courseId){
            $query->where('courses.id',$courseId);
        })
        ->with('course_students', function($query) use($courseId){
            $query->select('course_students.id','course_students.student_id','course_students.course_id')
            ->where('course_students.course_id',$courseId)
            ->with(['journals'=>function($q){
                $q->select('journals.id','journals.course_student_id')
                ->withCount('journalGoals')
                ->withCount(['journalGoals as active_journal_goals_count' => function ($q1) {
                    $q1->where('state', '1');
                }]);
            }]);
        })
        ->get();
        $studentIds = $students->pluck('id');
        $journalTimes = JournalTime::where('course_id',$courseId)->get();
        $allStudents = $this->model->select('id', 'student_name')
        ->whereNotIn('id', $studentIds)
        ->whereHas('class', function ($query) use ($courseId) {
            $query->whereHas('courses', function ($query1) use ($courseId) {
                $query1->where('id', $courseId);
            });
        })->get();
        $data = ['student'=>$students, 'allStudent'=>$allStudents, 'journalTimes'=>count($journalTimes)];
        if ($students->isEmpty()) {
            return response()->json(['error' => 'No students found for this class']);
        }
        return response()->json($data);
    }
}