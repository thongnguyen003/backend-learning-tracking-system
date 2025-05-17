<?php
namespace App\Repositories;
use App\Models\Course;
class CourseRepository extends Repository {
    public function __construct(Course $model){
        $this->model = $model;
    }
    // retrive data of courses and name of student and number of course flowing courses by studetn_id
    public function getCoursesDetailsByStudentId(int $studentId){
        $courses = Course::whereHas('students',function($query) use ($studentId){
            $query->where('students.id',$studentId);
        })
        ->with(['teacher'=>function($query1){
            $query1->select( 'teachers.id','teacher_name');
        }])
        ->withCount('students')
        ->with(['courseStudents' => function($query2) {
            $query2->select('id', 'course_students.course_id', 'course_students.student_id');
        }])
        ->get();
        if ($courses->isEmpty()) {
            return response()->json(['message' => 'No courses found for the given student ID'], 404);
        }
    
        return response()->json($courses);
    }
    
}