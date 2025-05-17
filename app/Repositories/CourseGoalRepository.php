<?php
// app/Repositories/CourseGoalRepository.php

namespace App\Repositories;

use App\Models\CourseGoal;
use App\Repositories\BaseRepository;

class CourseGoalRepository extends BaseRepository
{
    public function __construct(CourseGoal $model)
    {
        parent::__construct($model);
    }

    public function getByCourseStudentId($courseStudentId)
    {
        try {
            return CourseGoal::where('course_student_id', $courseStudentId)->get();
        } catch (\Exception $e) {
            // Log the exception or return a custom error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
