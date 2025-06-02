<?php
namespace App\Services;
use App\Repositories\CourseStudentRepository;
use App\Repositories\ClassRepository;
use App\Models\Classes;
class CourseStudentService extends BaseService{
    public function __construct(CourseStudentRepository $repo){
        parent::__construct($repo);
    }
    public function addStudentIntoCourseByClass($class_id,$course_id){
        $classRepository = new ClassRepository(new Classes);
        $students = $classRepository->findStudents($class_id);
        if($students && count($students) >0){
            foreach($students as $student){
                $student_id = $student->id;
                $this->repository->create(['course_id'=>$course_id,'student_id'=>$student_id]);
            }
            return true;
        }
        return false;
    }
}