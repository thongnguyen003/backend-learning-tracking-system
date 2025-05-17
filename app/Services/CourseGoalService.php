<?php
namespace App\Services;

use App\Repositories\CourseGoalRepository;
use App\Repositories\BaseRepository;

class CourseGoalService extends BaseService
{
    protected BaseRepository $repository;

    public function __construct(CourseGoalRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getGoalsByStudentId($courseStudentId)
    {
        return $this->repository->getByCourseStudentId($courseStudentId);
    }
}
