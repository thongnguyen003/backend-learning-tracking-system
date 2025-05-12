<?php

// app/Http/Controllers/CourseGoalController.php

namespace App\Http\Controllers;

use App\Services\CourseGoalService;
use Illuminate\Http\Request;

class CourseGoalController extends Controller
{
    protected $service;

    public function __construct(CourseGoalService $service)
    {
        $this->service = $service;
    }

    public function indexByStudent($courseStudentId)
    {
        $goals = $this->service->getGoalsByStudentId($courseStudentId);

        if ($goals->isEmpty()) {
            return response()->json(['message' => 'No course goals found for this student.'], 404);
        }

        return response()->json($goals);
    }

}