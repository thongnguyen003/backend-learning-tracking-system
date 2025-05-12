<?php
namespace App\Services;
use App\Repositories\CourseRepository;
class CourseService extends Service
{
    public function __construct(CourseRepository $repo)
    {
        $this->repository = $repo;
    }
    public function getCoursesDetailsByStudentId(int $studentId)
    {
        return $this->repository->getCoursesDetailsByStudentId($studentId);
    }
}
