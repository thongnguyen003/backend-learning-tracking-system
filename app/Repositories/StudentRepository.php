<?php
namespace App\Repositories;
use App\Models\Student;
use App\Models\JournalTime;
use Illuminate\Support\Facades\Hash;
class StudentRepository extends Repository{
    public function __construct(Student $model){
        $this->model = $model;
    }
    public function login(array $studentData){
        $student = $this->model->where('email',$studentData['email']);
        if($student && Hash::check($studentData['password'],$student->password)){
            return response()->json($student);
        }else{
            return response()->json(['error' => 'Unexited Account'], 401);
        }
    }
    public function getStudentById(int $id){
        $student = $this->model->find($id);
        if($student){
            return response()->json($student);
        }else{
            return response()->json(['error' => 'Unexited Account'], 401);
        }
    }
    public function updatePassword($id, $newPassword)
    {
        $student = $this->model->find($id);
        if ($student) {
            $student->password = Hash::make($newPassword);
            $student->save();
        }
    }
    

    public function findById(int $id){
        return $this->model->find($id);
    }

    public function update($id, $data)
    {
        $student = $this->findById($id);
        if (!$student) {
            throw new \Exception("Student not found with ID: {$id}");
        }
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

    
    public function getStudentsByClassId($classId)
    {
        return $this->model->where('class_id', $classId)->select('id', 'student_name','avatar')->get();
    }
}