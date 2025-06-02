<?php
namespace App\Repositories;
use App\Models\Course;
class CourseRepository extends BaseRepository {
    public function __construct(Course $model){
        parent::__construct($model);
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
        ->with(['courseStudents' => function($query2) use($studentId) {
            $query2->where('student_id',$studentId)->select('id', 'course_students.course_id', 'course_students.student_id');
        }])
        ->get();
        if ($courses->isEmpty()) {
            return response()->json(['message' => 'No courses found for the given student ID'], 404);
        }
    
        return response()->json($courses);
    }
    public function getCoursesDetailsByClassId(int $classId){
        $courses = Course::where('class_id',$classId)
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
    public function getCourseDetailsByCourseId(int $courseId){
        $course = Course::with('journalTimes')
        ->withCount('students')
        ->find($courseId);

        if (!$course) {
            return ['error' => 'Course not found for the given course ID'];
        }

        return $course;
    }
    public function create($data){
        return parent::create($data);
    }
    public function update(int $id,array $data){
        return parent::update( $id, $data);
    }
    public function find(int $id){
        return parent::find($id);
    }
}