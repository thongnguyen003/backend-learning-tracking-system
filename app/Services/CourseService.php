<?php
namespace App\Services;
use App\Repositories\CourseRepository;
class CourseService extends Service {
    public function __construct(CourseRepository $repo){
        $this->repository = $repo;
    }
    public function getCoursesDetailsByStudentId(int $studentId){
        return $this->repository->getCoursesDetailsByStudentId($studentId);
    }
    public function getCoursesDetailsByClassId(int $studentId){
        return $this->repository->getCoursesDetailsByClassId($studentId);
    }
    public function getCoursesDetailsByCourseId(int $courseId){
        return $this->repository->getCourseDetailsByCourseId($courseId);
    }
}