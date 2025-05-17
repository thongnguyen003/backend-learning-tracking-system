<?php

// app/Http/Controllers/CourseGoalController.php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CourseRequest;
use App\Services\CourseGoalService;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseGoalController extends Controller
{
    protected CourseGoalService $service;

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


    public function index(): JsonResponse
    {
        $courses = $this->service->getAll();
        return response()->json($courses);
    }

    public function show(int $id): JsonResponse
    {
        $course = $this->service->getById($id);
        if ($course) {
            return response()->json($course);
        }
        return response()->json(['message' => 'Course not found'], 404);
    }

    public function store(CourseRequest $request): JsonResponse
    {
        $data = $request->validated();
        $course = $this->service->create($data);
        return response()->json($course, 201);
    }


    public function update(CourseRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();  // Use validated data from the request
        $course = $this->service->update($id, $data);
        if ($course) {
            return response()->json($course);
        }
        return response()->json(['message' => 'Course not found or update failed'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->service->delete($id);
        if ($deleted) {
            return response()->json(['message' => 'Course deleted successfully']);
        }
        return response()->json(['message' => 'Course not found or delete failed'], 404);
    }
}