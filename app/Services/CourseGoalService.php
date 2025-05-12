<?php
namespace App\Services;

use App\Repositories\CourseGoalRepository;

class CourseGoalService
{
    protected $repository;

    public function __construct(CourseGoalRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getGoalsByStudentId($courseStudentId)
    {
        return $this->repository->getByCourseStudentId($courseStudentId);
    }
}