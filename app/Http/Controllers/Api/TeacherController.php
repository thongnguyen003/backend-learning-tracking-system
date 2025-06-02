<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Services\TeacherService;

class TeacherController extends Controller
{
    protected $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        $teachers = Teacher::all();
        return response()->json($teachers);
    }

    public function showByClassId(int $classId)
    {
        $teachers = $this->teacherService->findByClassId($classId);
        return response()->json($teachers);
    }
}
